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
Route::get('/usuarios/{mail}/{pass}', 'App\Http\Controllers\ControllerApiUsuarios@login')->name('usuarios.login');
Route::get('/dejargrupo/{id_usuario}', 'App\Http\Controllers\ControllerApiUsuarios@dejargrupo')->name('usuarios.dejargrupo');
Route::get('/unirseaungrupo/{id_usuario}/{id_grupo}', 'App\Http\Controllers\ControllerApiUsuarios@unirseaungrupo')->name('usuarios.unirseaungrupo');

Route::resource('/grupos', 'App\Http\Controllers\ControllerApiGrupos');
Route::get('/GetVecinosGrupo/{id_grupo}', 'App\Http\Controllers\ControllerApiGrupos@GetVecinosGrupo')->name('grupos.GetVecinosGrupo');
