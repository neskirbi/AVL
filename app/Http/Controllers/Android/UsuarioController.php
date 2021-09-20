<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use DB;

class UsuarioController extends Controller
{
    function Registrar(Request $request){
        $usuario = DB::table('usuarios')
        ->where('mail',$request->mail)
        ->first();

        if(!$usuario){
            
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
                return array('error' => "Error al registrar.");
            }
        }else{
            return array('error' => "El correo ya se encuentra en uso.");
        }

        
    }

    function Login(Request $request){
        $usuario = DB::table('usuarios')
        ->leftjoin('grupos', 'grupos.id_grupo', '=', 'usuarios.id_grupo')
        ->where('usuarios.mail',$request->mail)
        ->select('usuarios.id_usuario','usuarios.id_grupo',
        'usuarios.nombres','usuarios.apellidos',
        'usuarios.direccion','grupos.nombre','usuarios.pass')
        ->first();

        if($usuario){

            if($usuario->pass == $request->pass){
                $usuario_update=Usuario::find($usuario->id_usuario);
                $usuario_update->ult_login=GetDateTimeNow();
                $usuario_update->save();            
                
                return json_encode($usuario);
            }else{
                return array('error' => "Contraseña incorrecta.");
            }
            
        }else{
            return array('error' => "Usuario no registrado.");
        }
        

    }
}
