<?php

namespace App\Http\Controllers\Android;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Usuario;
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
        $grupo=Grupo::find($request->id_grupo);
        if($grupo){
            $usuario=Usuario::find($request->id_usuario);
            $usuario->id_grupo=$request->id_grupo;
            if($usuario->save()){
                return $grupo;
            }else{
                return array('error'=>'Error al guardar los datos.');
            }
        }else{
            return array('error'=>'El grupo no existe.');
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
}
