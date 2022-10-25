<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prealerta;

class AlertaController extends Controller
{
    function GetAlertas(Request $request){
        $prealertas=Prealerta::all();
        return RespuestaAndroid(1,'',$prealertas);
    }
}
