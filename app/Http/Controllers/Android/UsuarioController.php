<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use DB;

class UsuarioController extends Controller
{
    function Registrar(Request $request){
        $usuario=new Usuario();
        $usuario->id_usuario=GetUuid();
        $usuario->nombres=$request->nombres;
        $usuario->apellidos=$request->apellidos;
        $usuario->direccion=$request->direccion;
        $usuario->mail=$request->mail;
        $usuario->pass=$request->pass;
        $usuario->ult_login=GetDateTimeNow('Y-m-d H:i:s');
        
        if($usuario->save()){
            return $usuario;
        }else{
            return null;
        }
    }

    function Login(Request $request){
        $usuario = DB::table('usuarios')
        ->leftjoin('grupos', 'grupos.id_grupo', '=', 'usuarios.id_grupo')
        ->where('mail',$request->mail)->where('pass',$request->pass)
        ->select('usuarios.id_usuario','usuarios.nombres','usuarios.apellidos','usuarios.direccion','usuarios.id_grupo','grupos.id_usuario as id_usuario_grupo','grupos.nombre as nombre_grupo','usuarios.ult_login')
        ->first();

        if($usuario){
            $usuario_update=Usuario::find($usuario->id_usuario);
            $usuario_update->ult_login=GetDateTimeNow();
            $usuario_update->save();            
            return $usuario_update;
        }else{
               
            return $request;
        }
        

    }
}
