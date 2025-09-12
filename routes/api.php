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
 * Rutas Avisos
 */
//Consultar avisos
Route::get('Avisos/{id_grupo}', 'App\Http\Controllers\Android\AvisoController@Avisos');
//Crear Avisos
Route::Post('CrearAviso', 'App\Http\Controllers\Android\AvisoController@CrearAviso');
//Eliminar Avisos
Route::Post('EliminarAviso', 'App\Http\Controllers\Android\AvisoController@EliminarAviso');
 





/**
 * Rutas Usiarios 
 */
Route::Post('Login', 'App\Http\Controllers\Android\UsuarioController@Login');

Route::Post('Registro', 'App\Http\Controllers\Android\UsuarioController@Registrar');
 



/**
 * Rutas grupo
 */

Route::post('CrearGrupo', 'App\Http\Controllers\Android\GrupoController@CrearGrupo');

Route::post('UnirseGrupo', 'App\Http\Controllers\Android\GrupoController@UnirseGrupo');

Route::post('SalirdelGrupo', 'App\Http\Controllers\Android\GrupoController@SalirdelGrupo');



/**Mensajes
 * 
 * 
 */
Route::Post('GuardarMensaje', 'App\Http\Controllers\Android\MensajeController@GuardarMensaje');


Route::Post('ActualizarMensajes', 'App\Http\Controllers\Android\MensajeController@ActualizarMensajes');

//Route::get('migrupo/{id_grupo}', 'App\Http\Controllers\GrupoController@migrupo')->name('grupos.migrupo');
//Route::get('unirse/{id_usuario}/{id_grupo}', 'App\Http\Controllers\GrupoController@unirse')->name('grupos.unirse');
//Route::get('salir/{id_usuario}', 'App\Http\Controllers\GrupoController@salir')->name('grupos.salir');
//Route::get('/unirseconqr/{id_grupo}/{id_usuario}', 'App\Http\Controllers\GrupoController@unirseconqr')->name('grupos.unirse');



/**
 * 
 * Para el chat lo idel sera obtener los mensajes e tre la fecha de el ultimo que tienes a l mas reciente guardado para que sno consuma tanto la consulta 
 * y no estar obteniendo todos 
 */
