<?php

namespace App\Http\Controllers\Android;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Usuario;
use App\Models\Bloqueado;
use DB;

class ControllerApiGrupos extends Controller
{
     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CrearGrupo(Request $request)
    {
        

        
        if($request->id_usuario==null || $request->nombre==null)
        {
            return array('error'=>'Los datos no puedes ser nulos.');            
        }
        
        $usuario_update=Usuario::find($request->id_usuario);
        if($usuario_update){
            $grupo=new Grupo();
            $id_grupo=GetUuid();
            $grupo->id_grupo=$id_grupo;
            $grupo->id_usuario=$request->id_usuario;
            $grupo->nombre=$request->nombre;
            $grupo->save();

        
            $usuario_update->id_grupo=$id_grupo;
            $usuario_update->save();
            return $grupo;
        }else{
            return array('error'=>'El usuario no esta registrado.');
        }
        
    }

    function UnirseGrupo(Request $request){
        $request=PostmanAndroid($request);
        $grupo=Grupo::find($request[0]['id_grupo']);
        $bloqueado=Bloqueado::where('id_usuario',$request[0]['id_usuario'])->where('id_grupo',$request[0]['id_grupo'])->first();
        if($bloqueado){
            return RespuestaAndroid(0,'Estas bloqueado en este grupo.');
        }
        if($grupo){
            $usuario=Usuario::find($request[0]['id_usuario']);
            $usuario->id_grupo=$request[0]['id_grupo'];
            if($usuario->save()){            
                
                return RespuestaAndroid(1,'',$grupo);
            }else{
                return RespuestaAndroid(0,'Error al guardar los datos.');
            }
        }else{
            return RespuestaAndroid(0,'El grupo no existe.');
        }
    }

    function DejarGrupo(Request $request){
        $usuario=Usuario::find($request->id_usuario);
        if(!$usuario){
            return array('error'=>'El usuario no esta registrado.');
        }

        $usuario->id_grupo='';
        if($usuario->save()){
                return $request;
        }else{
                return array('error'=>'Error al salir del grupo.');
        }
    }

    function GetGrupo(Request $request){
        $request=PostmanAndroid($request);
        $usuario=Usuario::find($request[0]['id_usuario']);
        if($usuario){
            
            return RespuestaAndroid(1,'',$usuario);
        
        }else{
            return RespuestaAndroid(1,'No se encontro el usuario.');
        }
        
        
    }
}
