<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sugerencia extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_sugerencia'; // or null
    public $incrementing = false;
}
