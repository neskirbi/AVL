<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prealerta;
use App\Models\Alerta;
use DB;

class AlertaController extends Controller
{
    function GetPreAlertas(Request $request){
        $prealertas=Prealerta::all();
        return RespuestaAndroid(1,'',$prealertas);
    }

    function EnviarAlertas(Request $request){
        $request=PostmanAndroid($request);
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

    function GetAlertas(Request $request){
        $request=PostmanAndroid($request);
        
        //return count($request);
        $ids=($request[0]['ids']);
        $in=array();
        if(count($request)){
            for($i=0;$i<count($ids);$i++){
                $in[]=$ids[$i]['id_alerta'];
            }
            
        }
        $alertas=Alerta::select('id_alerta','created_at','asunto',DB::raw("(select concat(nombres,' ',apellidos) from usuarios where id_usuario=alertas.id_usuario) as nombre"),'imagen')->whereNotIn('id_alerta', $ids)->where('id_grupo',$request[0]['id_grupo'])->get();
        return RespuestaAndroid(1,'',$alertas);
    }
}
