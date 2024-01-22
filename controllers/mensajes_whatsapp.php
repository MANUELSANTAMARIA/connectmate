<?php 
include_once '../models/mensajes_whatsapp.php';
$msjwhatsapp = new msjwha();
session_name("connectmate");
session_start();
$id_usuario = $_SESSION["usuario"];


// Obtener los datos JSON desde la solicitud
$json_data = file_get_contents("php://input");

// Decodificar los datos JSON
$data = json_decode($json_data, true);
if($data["funcion"] == "txtwhatsapp"){
    // echo json_encode(["status" => "exit"]); 
    // echo json_encode($data["datosTabla"]);

    // preuba deinsercion
    // $nombre = "manuel";
    // $apellido = "santamaria";
    // $telefono = "099999999";
    // $mensaje = "sdhdjhsajhgahGXSHSJSJHJHD";
    // $msjwhatsapp->msjwhatsapp($nombre, $apellido, $telefono, $mensaje, $id_usuario);
    

    $datosTabla = $data["datosTabla"];
    $tipoMensaje = $data["tipo_mensaje"];
    $mensaje = $data["descripcion"];
    

    $msjwhatsapp->msjwhatsapp($datosTabla, $tipoMensaje, $mensaje, $id_usuario);
    ;
    
}



