<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mensaje;
class MensajeController extends Controller
{
    function GuardarMensaje(Request $request){
       $request=PostmanAndroid($request);

       foreach($request as $mensaje){
        //return $mensaje;
            if(!Mensaje::find($mensaje['id_mensaje'])){
                $mensajee=new Mensaje();
                $mensajee->id_mensaje=$mensaje['id_mensaje'];
                $mensajee->id_usuario=$mensaje['id_usuario'];
                $mensajee->id_grupo=$mensaje['id_grupo'];
                $mensajee->imagen=isset($mensaje['imagen']) ? $mensaje['imagen'] : '';
                $mensajee->mensaje=isset($mensaje['mensaje']) ? $mensaje['mensaje'] : '';
                $mensajee->audio=isset($mensaje['audio']) ? $mensaje['audio'] : '';
                $mensajee->video=isset($mensaje['video']) ? $mensaje['video'] : '';
                $mensajee->created_at=$mensaje['created_at'];
                $mensajee->updated_at=$mensaje['updated_at'];
                $mensajee->save();
            }
           
       }
       return RespuestaAndroid(1,'');
    }
}
