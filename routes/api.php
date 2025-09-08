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
Route::Post('Login', 'App\Http\Controllers\Android\UsuarioController@Login');

Route::Post('Registro', 'App\Http\Controllers\Android\UsuarioController@Registrar');
 
Route::Post('GetDatos', 'App\Http\Controllers\Android\UsuarioController@GetDatos');

Route::Post('GetPreAlertas', 'App\Http\Controllers\Android\AlertaController@GetPreAlertas');

Route::Post('GetAlertas', 'App\Http\Controllers\Android\AlertaController@GetAlertas');

Route::Post('GetAvisos', 'App\Http\Controllers\Android\AvisoController@GetAvisos');

Route::Post('EnviarAlertas', 'App\Http\Controllers\Android\AlertaController@EnviarAlertas');

Route::Post('EnviarAvisos', 'App\Http\Controllers\Android\AvisoController@EnviarAvisos');

Route::Post('UpdateDatos', 'App\Http\Controllers\Android\UsuarioController@UpdateDatos');

Route::Post('UpdatePass', 'App\Http\Controllers\Android\UsuarioController@UpdatePass');


/**
 * Rutas grupo
 */

Route::post('CrearGrupo', 'App\Http\Controllers\Android\GrupoController@CrearGrupo');

Route::post('UnirseGrupo', 'App\Http\Controllers\Android\GrupoController@UnirseGrupo');

Route::post('SalirdelGrupo', 'App\Http\Controllers\Android\GrupoController@SalirdelGrupo');

Route::post('GetGrupo', 'App\Http\Controllers\Android\GrupoController@GetGrupo');

Route::Post('GetVecinos', 'App\Http\Controllers\Android\VecinoController@GetVecinos');

Route::Post('GetBloqueados', 'App\Http\Controllers\Android\VecinoController@GetBloqueados');

Route::Post('BloquearVecino', 'App\Http\Controllers\Android\VecinoController@BloquearVecino');

Route::Post('DesbloquearVecino', 'App\Http\Controllers\Android\VecinoController@DesbloquearVecino');

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
