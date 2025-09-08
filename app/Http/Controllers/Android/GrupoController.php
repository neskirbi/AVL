<?php

namespace App\Http\Controllers\Android;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Grupo;
use App\Models\Usuario;
use App\Models\Bloqueado;
use DB;

class GrupoController extends Controller
{
     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CrearGrupo(Request $request) {
    // Validar que los campos requeridos no sean nulos
    if ($request->id_usuario == null || $request->grupo == null) { // Cambiado de 'nombre' a 'grupo'
        return response()->json([
            'success' => false,
            'error' => 'Los datos no pueden ser nulos.',
            'required_fields' => ['id_usuario', 'grupo'] // Cambiado
        ], 400);
    }
    
    try {
        // Buscar el usuario
        $usuario_update = Usuario::find($request->id_usuario);
        
        if (!$usuario_update) {
            return response()->json([
                'success' => false,
                'error' => 'El usuario no está registrado.'
            ], 404);
        }
        
        // Crear el nuevo grupo
        $grupo = new Grupo();
        $id = GetUuid();
        $grupo->id = $id;
        $grupo->id_usuario = $request->id_usuario;
        $grupo->grupo = $request->grupo; // Cambiado de 'nombre' a 'grupo'
        $grupo->descripcion = $request->descripcion ?? null;
        $grupo->created_at = now();
        $grupo->updated_at = now();
        $grupo->save();

        // Actualizar el usuario con el ID del grupo
        $usuario_update->id_grupo = $id;
        $usuario_update->save();
        
        // Devolver respuesta exitosa con todos los datos del grupo
        return response()->json([
            'success' => true,
            'message' => 'Grupo creado exitosamente',
            'grupo' => $grupo,
            'usuario_actualizado' => true
        ], 201);
        
    } catch (\Exception $e) {
        // Manejar cualquier error inesperado
        return response()->json([
            'success' => false,
            'error' => 'Error al crear el grupo: ' . $e->getMessage()
        ], 500);
    }
}

    function UnirseGrupo(Request $request){
        // Validar que los datos necesarios estén presentes
        if (!$request->has('id') || !$request->has('id_usuario')) {
            return response()->json([
                'success' => false,
                'error' => 'Datos incompletos: id e id_usuario son requeridos'
            ], 400);
        }

        $id = $request->id; // CAMBIADO: de id_grupo a id
        $id_usuario = $request->id_usuario;

        // Verificar si el grupo existe
        $grupo = Grupo::find($id); // CAMBIADO: buscar por id
        if (!$grupo) {
            return response()->json([
                'success' => false,
                'error' => 'El grupo no existe'
            ], 404);
        }

        // Verificar si el usuario está bloqueado en este grupo
        $bloqueado = Bloqueado::where('id_usuario', $id_usuario)
                            ->where('id_grupo', $id) // CAMBIADO: de id_grupo a id
                            ->first();
        if ($bloqueado) {
            return response()->json([
                'success' => false,
                'error' => 'Estás bloqueado en este grupo'
            ], 403);
        }

        // Verificar si el usuario existe
        $usuario = Usuario::find($id_usuario);
        if (!$usuario) {
            return response()->json([
                'success' => false,
                'error' => 'Usuario no encontrado'
            ], 404);
        }

        // Actualizar el grupo del usuario
        $usuario->id_grupo = $id; // CAMBIADO: de id_grupo a id
        
        if ($usuario->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Te has unido al grupo exitosamente',
                'grupo' => $grupo
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Error al guardar los datos'
            ], 500);
        }
    }

   function SalirdelGrupo(Request $request){
        // Validar que venga el id_usuario
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        // Buscar el usuario
        $usuario = Usuario::where('id_usuario', $request->id_usuario)->first();

        if (!$usuario) {
            return response()->json([
                'error' => 'Usuario no encontrado'
            ], 404);
        }

        // Eliminar el id_grupo del usuario (ponerlo en null o vacío)
        $usuario->update([
            'id_grupo' => ''
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Has salido del grupo exitosamente'
        ], 200);
    }
    
}
