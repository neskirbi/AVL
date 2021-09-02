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

Route::Post('Registro', 'App\Http\Controllers\Android\UsuarioController@Registrar');

Route::Post('Login', 'App\Http\Controllers\Android\UsuarioController@Login');

Route::get('/dejargrupo/{id_usuario}', 'App\Http\Controllers\ControllerApiUsuarios@dejargrupo')->name('usuarios.dejargrupo');

Route::resource('/grupos', 'App\Http\Controllers\ControllerApiGrupos');
Route::get('/migrupo/{id_grupo}', 'App\Http\Controllers\ControllerApiGrupos@migrupo')->name('grupos.migrupo');
Route::get('/unirse/{id_usuario}/{id_grupo}', 'App\Http\Controllers\ControllerApiGrupos@unirse')->name('grupos.unirse');
Route::get('/salir/{id_usuario}', 'App\Http\Controllers\ControllerApiGrupos@salir')->name('grupos.salir');
//Route::get('/unirseconqr/{id_grupo}/{id_usuario}', 'App\Http\Controllers\ControllerApiGrupos@unirseconqr')->name('grupos.unirse');

Route::resource('/prealertas', 'App\Http\Controllers\ControllerApiPrealertas');

Route::resource('/sugerencias','App\Http\Controllers\ControllerApiSugerencias');
