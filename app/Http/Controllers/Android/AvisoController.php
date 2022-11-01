<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aviso;
use DB;
class AvisoController extends Controller
{


    function EnviarAvisos(Request $request){
        $request=PostmanAndroid($request);
        $aviso=new Aviso();
        $aviso->id_aviso=GetUuid();
        $aviso->id_grupo=$request[0]['id_grupo'];
        $aviso->id_usuario=$request[0]['id_usuario'];
        $aviso->asunto=$request[0]['asunto'];
        $aviso->mensaje=$request[0]['mensaje'];
        $aviso->save();
        return RespuestaAndroid(1,'');

    }
    
    
    function GetAvisos(Request $request){
        $request=PostmanAndroid($request);
        
        //return count($request);
        $ids=($request[0]['ids']);
        $in=array();
        if(count($request)){
            for($i=0;$i<count($ids);$i++){
                $in[]=$ids[$i]['id_aviso'];
            }
            
        }
        $alertas=Aviso::select('id_aviso',
        'id_grupo',
        'created_at',
        'asunto',
        'mensaje',DB::raw("(select concat(nombres,' ',apellidos) from usuarios where id_usuario=avisos.id_usuario) as nombre"))->whereNotIn('id_aviso', $ids)->where('id_grupo',$request[0]['id_grupo'])->get();
        return RespuestaAndroid(1,'',$alertas);
    }
}
