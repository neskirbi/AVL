<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    //protected $fillable = ['id_usuario','nombres','apellidos','direccion','mail','pass','ult_login'];
    protected $primaryKey = 'id_usuario'; // or null
    public $incrementing = false;
    protected $fillable = [
        'id_usuario',
        'id_grupo',
        'nombres',
        'apellidos',
        'mail',
        'pass',
        'direccion',
        'fecha',
        'ult_login', // ← AÑADE ESTA LÍNEA
        'updated_at'
    ];
}
