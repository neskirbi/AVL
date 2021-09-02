<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function Login($mail,$pass){
        $usuario = DB::table('usuarios')
        ->leftjoin('grupos', 'grupos.id_grupo', '=', 'usuarios.id_grupo')
        ->where('mail',$mail)->where('pass',$pass)
        ->get(['usuarios.id_usuario','usuarios.nombres','usuarios.apellidos','usuarios.direccion','usuarios.id_grupo','grupos.id_usuario as id_usuario_grupo','grupos.nombre as nombre_grupo','usuarios.ult_login']);
        if(count($usuario)>0){
            $usuario_update=Usuario::find($usuario[0]->id_usuario);
            $usuario_update->ult_login=GetDateTimeNow();
            $usuario_update->save();
        
        }
        
        return $usuario;

    }
}
