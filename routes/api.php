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


/**
 * Rutas Usiarios 
 */

Route::Post('Registro', 'App\Http\Controllers\Android\UsuarioController@Registrar');

Route::Post('Login', 'App\Http\Controllers\Android\UsuarioController@Login');

Route::Post('GetDatos', 'App\Http\Controllers\Android\UsuarioController@GetDatos');


Route::Post('UpdateDatos', 'App\Http\Controllers\Android\UsuarioController@UpdateDatos');

Route::Post('UpdatePass', 'App\Http\Controllers\Android\UsuarioController@UpdatePass');


Route::post('CrearGrupo', 'App\Http\Controllers\Android\ControllerApiGrupos@CrearGrupo');

Route::post('UnirseGrupo', 'App\Http\Controllers\Android\ControllerApiGrupos@UnirseGrupo');

Route::post('DejarGrupo', 'App\Http\Controllers\Android\ControllerApiGrupos@DejarGrupo');


Route::post('GetGrupo', 'App\Http\Controllers\Android\ControllerApiGrupos@GetGrupo');


Route::Post('GetVecinos', 'App\Http\Controllers\Android\VecinoController@GetVecinos');

Route::Post('GetBloqueados', 'App\Http\Controllers\Android\VecinoController@GetBloqueados');



Route::Post('BloquearVecino', 'App\Http\Controllers\Android\VecinoController@BloquearVecino');

Route::Post('DesbloquearVecino', 'App\Http\Controllers\Android\VecinoController@DesbloquearVecino');

//Route::get('migrupo/{id_grupo}', 'App\Http\Controllers\ControllerApiGrupos@migrupo')->name('grupos.migrupo');
//Route::get('unirse/{id_usuario}/{id_grupo}', 'App\Http\Controllers\ControllerApiGrupos@unirse')->name('grupos.unirse');
//Route::get('salir/{id_usuario}', 'App\Http\Controllers\ControllerApiGrupos@salir')->name('grupos.salir');
//Route::get('/unirseconqr/{id_grupo}/{id_usuario}', 'App\Http\Controllers\ControllerApiGrupos@unirseconqr')->name('grupos.unirse');

Route::resource('/prealertas', 'App\Http\Controllers\ControllerApiPrealertas');

Route::resource('/sugerencias','App\Http\Controllers\ControllerApiSugerencias');
