<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mensaje;
use DB;
class MensajeController extends Controller
{
    function GuardarMensaje(Request $request){
       $request=PostmanAndroid($request);

       foreach($request as $mensaje){
        
            if(!Mensaje::find($mensaje['id_mensaje'])){
                $mensajee=new Mensaje();
                $mensajee->id_mensaje=$mensaje['id_mensaje'];
                $mensajee->id_usuario=$mensaje['id_usuario'];
                $mensajee->id_grupo=$mensaje['id_grupo'];
                $mensajee->imagen=isset($mensaje['imagen']) ? $mensaje['imagen'] : '';
                $mensajee->mensaje=isset($mensaje['mensaje']) ? $mensaje['mensaje'] : '';
                $mensajee->audio=isset($mensaje['audio']) ? $mensaje['audio'] : '';
                $mensajee->video=isset($mensaje['video']) ? $mensaje['video'] : '';
                //$mensajee->created_at=$mensaje['created_at'];
                //$mensajee->updated_at=$mensaje['updated_at'];
                $mensajee->save();
            }
           
       }
       return RespuestaAndroid(1,'');
    }


    function ActualizarMensajes(Request $request){
        $request=PostmanAndroid($request);
        //return $request;
        $id=$request[0]['id'];
        $id_grupo=$request[0]['id_grupo'];
        

        if($id==""){

            $mensaje=Mensaje::select('mensajes.id_mensaje',
            DB::RAW("(select concat(usuarios.nombres,' ',usuarios.apellidos) from usuarios where id_usuario=mensajes.id_usuario) as nombre"),
            'mensajes.id_usuario','mensajes.imagen','mensajes.video','mensajes.audio','mensajes.mensaje','mensajes.created_at','mensajes.updated_at')
            ->whereraw(" id_grupo='".$id_grupo."'")
            ->get();


        }else{
            $mensaje=Mensaje::select('mensajes.id_mensaje',
            DB::RAW("(select concat(usuarios.nombres,' ',usuarios.apellidos) from usuarios where id_usuario=mensajes.id_usuario) as nombre"),
            'mensajes.id_usuario','mensajes.imagen','mensajes.video','mensajes.audio','mensajes.mensaje','mensajes.created_at','mensajes.updated_at')
            ->whereraw("created_at > (select created_at from mensajes where id_mensaje='".$id."') and id_grupo='".$id_grupo."'")
            ->get();
        }
        
        return RespuestaAndroid(1,count($mensaje),$mensaje);

    }
}
