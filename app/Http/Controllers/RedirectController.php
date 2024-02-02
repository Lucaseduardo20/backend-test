<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Redirect;
use App\Http\Requests\RedirectRequest;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\RedirectUpdateRequest;
use Illuminate\Support\Facades\Redirect as LaravelRedirect;

class RedirectController extends Controller
{
    public function show(Redirect $redirect)
    {
        return view('redirect.show', compact('redirect'));
    }

    public function store(RedirectRequest $request)
    {
        $urlDestino = $request->input('url_destino');

        $response = Http::get($urlDestino);
        if ($response->status() !== 200) {
            return response()->json(['error' => 'A URL de destino não está ativa.'], 400);
        }

        // Verificar se a URL aponta para a própria aplicação
        if (parse_url($urlDestino, PHP_URL_HOST) === request()->getHttpHost()) {
            return response()->json(['error' => 'A URL de destino não pode apontar para a própria aplicação.'], 400);
        }
        $redirect = Redirect::create(['url_destino' => $urlDestino]);

        return response()->json($redirect, 201);
    }

    public function index()
    {
        $redirects = Redirect::latest()->get();

        return response()->json($redirects);
    }

    public function update(RedirectUpdateRequest $request, Redirect $redirect)
    {
        $urlDestino = $request->input('url_destino');

        $response = Http::get($urlDestino);
        if ($response->status() !== 200) {
            return response()->json(['error' => 'A URL de destino não está ativa.'], 400);
        }

        $redirect->update(['url_destino' => $urlDestino]);

        return response()->json($redirect);
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();

        return response()->json(['message' => 'Redirect deletado com sucesso.']);
    }

    public function redirect(Request $request, $redirectCode)
    {
        $redirect = Redirect::where('code', $redirectCode)->first();

        if (!$redirect) {
            abort(404, 'Redirect não encontrado');
        }

        // Registro de acesso no RedirectLog
        RedirectLog::create([
            'redirect_id' => $redirect->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'query_params' => $request->query(),
            'access_time' => now(),
        ]);

        // Fundir query params da request com os do redirect (prioridade para a request)
        $mergedQueryParams = array_merge($redirect->parsed_query_params, $request->query());

        // Remover query params vazios
        $filteredQueryParams = array_filter($mergedQueryParams, function ($value) {
            return $value !== '';
        });

        // Construir a URL de destino com os query params
        $destinationUrl = $redirect->url_destino . '?' . http_build_query($filteredQueryParams);

        return LaravelRedirect::away($destinationUrl);
    }
}
