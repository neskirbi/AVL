<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Aviso;
use App\Models\Grupo;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AvisoController extends Controller
{
    /**
     * Obtener todos los avisos de un grupo
     */
    public function Avisos($id_grupo): JsonResponse
    {
        try {
            // Verificar que el grupo existe
            $grupo = Grupo::find($id_grupo);
            if (!$grupo) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Grupo no encontrado'
                ], 404);
            }

            // Obtener avisos con información del usuario que los creó
            $avisos = Aviso::with('usuario:id_usuario,nombres,apellidos')
                ->where('id_grupo', $id_grupo)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'avisos' => $avisos,
                'total' => $avisos->count()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al obtener avisos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo aviso
     */
    public function CrearAviso(Request $request): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            // Validar los datos de entrada
            $validator = Validator::make($request->all(), [
                'id_aviso' => 'required|string|max:32',
                'id_grupo' => 'required|string|max:32',
                'id_usuario' => 'required|string|max:32',
                'titulo' => 'required|string|max:150',
                'aviso' => 'required|string',
                'fecha' => 'required|numeric' // timestamp en milisegundos desde Android
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Datos de entrada inválidos',
                    'errores' => $validator->errors()
                ], 422);
            }

            // Verificar que el grupo existe
            $grupo = Grupo::find($request->id_grupo);
            if (!$grupo) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Grupo no encontrado'
                ], 404);
            }

            // Verificar que el usuario existe
            $usuario = Usuario::find($request->id_usuario);
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Usuario no encontrado'
                ], 404);
            }

            // Verificar que el usuario es administrador del grupo
            if ($grupo->id_usuario !== $request->id_usuario) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Solo el administrador del grupo puede crear avisos'
                ], 403);
            }

            // Convertir timestamp de milisegundos a fecha
            $fecha = date('Y-m-d H:i:s', $request->fecha / 1000);

            // Crear el aviso
            $aviso = Aviso::create([
                'id_aviso' => $request->id_aviso,
                'id_grupo' => $request->id_grupo,
                'id_usuario' => $request->id_usuario,
                'titulo' => $request->titulo,
                'aviso' => $request->aviso,
                'fecha' => $fecha,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'mensaje' => 'Aviso creado exitosamente',
                'aviso' => $aviso
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al crear aviso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un aviso
     */
    public function EliminarAviso(Request $request): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            // Validar los datos de entrada
            $validator = Validator::make($request->all(), [
                'id_aviso' => 'required|string|max:32',
                'id_usuario' => 'required|string|max:32'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Datos de entrada inválidos',
                    'errores' => $validator->errors()
                ], 422);
            }

            // Obtener el aviso
            $aviso = Aviso::find($request->id_aviso);
            if (!$aviso) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Aviso no encontrado'
                ], 404);
            }

            // Verificar que el grupo existe
            $grupo = Grupo::find($aviso->id_grupo);
            if (!$grupo) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Grupo no encontrado'
                ], 404);
            }

            // Verificar que el usuario es administrador del grupo del aviso
            if ($grupo->id_usuario !== $request->id_usuario) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Solo el administrador del grupo puede eliminar avisos'
                ], 403);
            }

            // Eliminar el aviso
            $aviso->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'mensaje' => 'Aviso eliminado exitosamente'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al eliminar aviso: ' . $e->getMessage()
            ], 500);
        }
    }
}