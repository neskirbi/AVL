<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/usuarios', 'App\Http\Controllers\ControllerApiUsuarios');
Route::get('/login/{mail}/{pass}', 'App\Http\Controllers\ControllerApiUsuarios@login')->name('usuarios.login');
Route::get('/dejargrupo/{id_usuario}', 'App\Http\Controllers\ControllerApiUsuarios@dejargrupo')->name('usuarios.dejargrupo');

Route::resource('/grupos', 'App\Http\Controllers\ControllerApiGrupos');
Route::get('/unirse/{id_usuario}/{id_grupo}', 'App\Http\Controllers\ControllerApiUsuarios@unirse')->name('usuarios.unirse');
Route::get('/migrupo/{id_grupo}', 'App\Http\Controllers\ControllerApiGrupos@migrupo')->name('grupos.migrupo');

Route::resource('/prealertas', 'App\Http\Controllers\ControllerApiPrealertas');
