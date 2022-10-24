<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloqueado extends Model
{
    use HasFactory; 
    protected $primaryKey = 'id_bloqueado'; // or null
    public $incrementing = false;
}
