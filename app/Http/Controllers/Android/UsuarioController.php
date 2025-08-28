<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Usuario;
use DB;

class UsuarioController extends Controller
{
    function Registrar(Request $request) {

        $validator = Validator::make($request->all(), [
            'mail' => 'required|mail',
            'pass' => 'required|min:6'
        ]);

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
        $usuario->pass =password_hash($request->pass,PASSWORD_DEFAULT); // ¡IMPORTANTE! Encriptar contraseña
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
       

        // Validación de datos
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'pass' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        // Buscar usuario por email (usando el campo 'mail' de tu tabla)
        $usuario = Usuario::where('mail', $request->email)->first();

        if (!$usuario) {
            return response()->json([
                'error' => 'Error de Correo'
            ], 401);
        }

        // Verificar contraseña (comparando con el campo 'pass' de tu tabla)
        if (!password_verify($request->pass, $usuario->pass)) {
            return response()->json([
                'error' => 'Error de Contrasenia'
            ], 401);
        }

        // Actualizar último login
        $usuario->update([
            'ult_login' => now()
        ]);

        // Si usas autenticación con tokens, descomenta las siguientes líneas:
        /*
        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'usuario' => $usuario,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
        */

        // Si NO usas tokens, devuelve solo el usuario:
        return response()->json([
            'usuario' => $usuario,
            'message' => 'Login exitoso'
        ]);
        

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
