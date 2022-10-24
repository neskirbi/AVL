<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Bloqueado;
use DB;

class VecinoController extends Controller
{

    function GetVecinos(Request $request){
        $request=PostmanAndroid($request);
        $vecinos=Usuario::select('usuarios.id_usuario','usuarios.direccion',DB::RAW(' concat(usuarios.nombres,\' \',usuarios.apellidos) as nombre'))
        ->where('usuarios.id_grupo',$request[0]['id_grupo'])
        ->whereraw('usuarios.id_usuario not in (select id_usuario from bloqueados where id_grupo=\''.$request[0]['id_grupo'].'\')')
        ->get();
        if($vecinos){
            return RespuestaAndroid(1,'',$vecinos);
        }else{
            return RespuestaAndroid(0,'Error de id.');
        }
    }


    function GetBloqueados(Request $request){
        $request=PostmanAndroid($request);
        $vecinos=Bloqueado::join('usuarios','usuarios.id_usuario','=','bloqueados.id_usuario')
        ->select('usuarios.id_usuario','usuarios.direccion',DB::RAW(' concat(usuarios.nombres,\' \',usuarios.apellidos) as nombre'))
        ->where('bloqueados.id_grupo',$request[0]['id_grupo'])->get();
        if($vecinos){
            return RespuestaAndroid(1,'',$vecinos);
        }else{
            return RespuestaAndroid(0,'Error de id.');
        }
    }


    function BloquearVecino(Request $request){
        $request=PostmanAndroid($request);
        $bloqueado=new Bloqueado();
        $bloqueado->id_bloqueado=GetUuid();
        $bloqueado->id_usuario=$request[0]['id_usuario'];
        $bloqueado->id_grupo=$request[0]['id_grupo'];
        $bloqueado->save();
        return RespuestaAndroid(1,'Usario Bloqueado.');
        
    }

    function DesbloquearVecino(Request $request){
        $request=PostmanAndroid($request);
        $bloqueado=Bloqueado::where('id_usuario',$request[0]['id_usuario'])->where('id_grupo',$request[0]['id_grupo'])->first();
        if( $bloqueado){
            $bloqueado->delete();
            return RespuestaAndroid(1,'Usario Desbloqueado.');
        
        }else{
            return RespuestaAndroid(1,'Usario Desbloqueado.');
        }
        
        
    }
}
