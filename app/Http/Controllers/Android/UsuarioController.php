<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use DB;

class UsuarioController extends Controller
{
    function Registrar(Request $request) {
    // Verificar si el usuario ya existe
    $usuarioExistente = DB::table('usuarios')
        ->where('mail', $request->mail)
        ->first();

    if ($usuarioExistente) {
        return response()->json([
            'error' => 'El correo ya se encuentra en uso'
        ], 409);
    }

    // Crear nuevo usuario
    $usuario = new Usuario();
    $usuario->id_usuario = GetUuid();
    $usuario->id_grupo = $request->id_grupo ?? 'usuario'; // Valor por defecto
    $usuario->nombres = $request->nombres;
    $usuario->apellidos = $request->apellidos;
    $usuario->direccion = $request->direccion;
    $usuario->mail = $request->mail;
    $usuario->pass = ($request->pass); // ¡IMPORTANTE! Encriptar contraseña
    $usuario->fecha = now();
    $usuario->ult_login = now();
    $usuario->updated_at = now();

    if ($usuario->save()) {
        return response()->json([
            'message' => 'Registro exitoso',
            'usuario' => $usuario
        ], 201);
    } else {
        return response()->json([
            'error' => 'Error al registrar'
        ], 500);
    }
}

    function Login(Request $request){
        $request=PostmanAndroid($request);
        
        $usuario = DB::table('usuarios')
        ->leftjoin('grupos', 'grupos.id_grupo', '=', 'usuarios.id_grupo')
        ->where('usuarios.mail',$request[0]['mail'])
        ->select('usuarios.id_usuario','usuarios.id_grupo',
        'usuarios.nombres','usuarios.apellidos',
        'usuarios.direccion','grupos.nombre','usuarios.pass')
        ->first();

        if($usuario){

            if($usuario->pass == $request[0]['pass']){
                $usuario_update=Usuario::find($usuario->id_usuario);
                $usuario_update->ult_login=GetDateTimeNow();
                $usuario_update->save();            
                
               
                return RespuestaAndroid(1,'',array(0=>$usuario));
            }else{
                
                return RespuestaAndroid(0,'Contraseña incorrecta.');
                
            }
            
        }else{
            return RespuestaAndroid(0,'Usuario no registrado.');
            
        }
        

    }

    function GetDatos(Request $request){
        $request=PostmanAndroid($request);
        $usuario=Usuario::find($request[0]['id']);
        if($usuario){
            return RespuestaAndroid(1,'',$usuario);
        }else{
            return RespuestaAndroid(0,'Error de id.');
        }
        
    }

    function UpdateDatos(Request $request){
        $request=PostmanAndroid($request);
        $usuario=Usuario::find($request[0]['id']);
        if($usuario){
            $usuario->nombres=$request[0]['nombres'];
            $usuario->apellidos=$request[0]['apellidos'];
            $usuario->direccion=$request[0]['direccion'];
            $usuario->ubicacion=$request[0]['ubicacion'];
            $usuario->save();
            return RespuestaAndroid(1,'Datos Actualizados.');
        }else{
            return RespuestaAndroid(0,'Error de id.');
        }
        
    }

    function UpdatePass(Request $request){
        $request=PostmanAndroid($request);
        $usuario=Usuario::find($request[0]['id']);
        if($usuario){
            if($usuario->pass==$request[0]['pass']){
                $usuario->pass=$request[0]['pass1'];
                $usuario->save();
                return RespuestaAndroid(1,'Contraseña Actualizada.');
            }else{
                return RespuestaAndroid(0,'Error de contreseña.');
            }
            
           
        }else{
            return RespuestaAndroid(0,'Error de id.');
        }
        
    }
}
