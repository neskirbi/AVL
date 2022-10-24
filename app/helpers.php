<?php

function GetUuid(){
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); 
    return str_replace("-","",vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
}


function GetDateTimeNow(){
    return date('Y-m-d H:i:s');
}


function PostmanAndroid($request){
    if(isset($request->android)){
        $request=$request->android;
    }else{
        $request=str_replace("\"",'"',json_encode($request->all()));
    }
    return json_decode($request,1);
}


function RespuestaAndroid($status,$msn,$datos=array()){
    $respuesta=array();
    if($status){
        $respuesta[]=array('status'=>$status,'msn'=>$msn,'datos'=>$datos);
    }else{
        $respuesta[]=array('status'=>$status,'msn'=>$msn);
    }
    
    return $respuesta;
}
?>