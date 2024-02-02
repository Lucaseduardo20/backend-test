<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Redirect;

class RedirectController extends Controller
{
    public function show(Redirect $redirect)
    {
        return view('redirect.show', compact('redirect'));
    }
}
