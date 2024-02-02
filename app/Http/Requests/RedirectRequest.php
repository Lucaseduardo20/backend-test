<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedirectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'url_destino' => ['required', 'url', 'active_url', 'starts_with:https'],
        ];
    }
}