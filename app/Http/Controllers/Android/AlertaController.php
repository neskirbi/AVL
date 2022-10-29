<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prealerta;
use App\Models\Alerta;

class AlertaController extends Controller
{
    function GetAlertas(Request $request){
        $prealertas=Prealerta::all();
        return RespuestaAndroid(1,'',$prealertas);
    }

    function EnviarAlertas(Request $request){
        $request=PostmanAndroid($request);
        $request[0]['id_alerta'];
        $alerta=new Alerta();
        $alerta->id_alerta=GetUuid();
        $alerta->id_grupo=$request[0]['id_grupo'];
        $alerta->id_usuario=$request[0]['id_usuario'];
        $alerta->imagen=$request[0]['imagen'];
        $alerta->asunto=$request[0]['asunto'];
        $alerta->mensaje="";
        $alerta->save();
        return RespuestaAndroid(1,'');

    }
}
