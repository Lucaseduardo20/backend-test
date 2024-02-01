<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/r/{redirect}', 'RedirectController@redirect');
Route::resource('redirects', 'RedirectController');
Route::get('redirects/{redirect}/stats', 'RedirectController@stats');
Route::get('redirects/{redirect}/logs', 'RedirectLogController@index');
