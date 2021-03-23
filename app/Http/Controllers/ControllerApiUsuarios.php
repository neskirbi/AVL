<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Grupo;
use DB;

class ControllerApiUsuarios extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return GetUuid();
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
    public function store(Request $request)
    {
        $usuario=new Usuario();
        $usuario->id_usuario=GetUuid();
        $usuario->nombres=$request->nombres;
        $usuario->apellidos=$request->apellidos;
        $usuario->direccion=$request->direccion;
        $usuario->mail=$request->mail;
        $usuario->pass=$request->pass;
        $usuario->ult_login=GetDateTimeNow('Y-m-d H:i:s');
        $usuario->save();
        return $usuario;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_usuario)
    {
        $usuario=Usuario::find($id_usuario);
        
        return $usuario;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_usuario)
    {
        $usuario_update=Usuario::find($id_usuario);
        $usuario->nombres=$request->nombres;
        $usuario->apellidos=$request->apellidos;
        $usuario->direccion=$request->direccion;
        $usuario->pass=$request->pass;
        $usuario_update->save();
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

    public function login($mail,$pass){
        $usuario = DB::table('usuarios')
        ->leftjoin('grupos', 'grupos.id_grupo', '=', 'usuarios.id_grupo')
        ->where('mail',$mail)->where('pass',$pass)
        ->get(['usuarios.id_usuario','usuarios.nombres','usuarios.apellidos','usuarios.direccion','usuarios.id_grupo','grupos.nombre as nombre_grupo','usuarios.ult_login']);
        if(count($usuario)>0){
            $usuario_update=Usuario::find($usuario[0]->id_usuario);
            $usuario_update->ult_login=GetDateTimeNow();
            $usuario_update->save();
        
        }
        
        return $usuario;

    }


    public function dejargrupo($id_usuario){
        $usuario_update=Usuario::find($id_usuario);       
        $usuario_update->id_grupo='';
        $usuario_update->save();
        
        return $usuario_update;

    }

    public function unirseaungrupo($id_usuario,$id_grupo){
        $grupo=Grupo::find($id_grupo);    

        if($grupo){
            $usuario_update=Usuario::find($id_usuario);       
            $usuario_update->id_grupo=$id_grupo;
            $usuario_update->save();
            return $usuario_update;
        }
        
        

    }
}
