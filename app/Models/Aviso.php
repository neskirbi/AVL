<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    use HasFactory;

    protected $table = 'avisos';
    protected $primaryKey = 'id_aviso';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_aviso',
        'id_grupo',
        'id_usuario',
        'titulo',
        'aviso',
        'fecha',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con el usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con el grupo
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id');
    }
}