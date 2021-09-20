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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return'ok';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_grupo)
    {
        $grupo=Grupo::find($id_grupo);
        return $grupo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function migrupo($id_grupo){
        $usuarios = DB::table('usuarios')
        ->where('id_grupo',$id_grupo)
        ->get(['id_usuario','nombres','apellidos','direccion','ult_login']);
        return $usuarios;
    }

    public function unirse($id_usuario,$id_grupo){
        $grupo=Grupo::find($id_grupo);    

        if($grupo){
            $usuario_update=Usuario::find($id_usuario);       
            $usuario_update->id_grupo=$id_grupo;
            $usuario_update->save();
            return $grupo;
        }
        
        

    }

    
    public function salir($id_usuario){
        $usuario_update=Usuario::find($id_usuario);       
        $usuario_update->id_grupo='';
        $usuario_update->save();
        
        return $usuario_update;

    }
}
