<?php

session_name("connectmate");
//inciar sesiones 
session_start();
$id_usuario = $_SESSION["usuario"];
const TOKEN_ANDERCODE = "MANUELSANTAMARIALARA";
// const WEBHOOK_URL = "https://samperza.com/cnt-mensaje/cnt-whatsapp/webhook.php";

if($_SESSION['us_tipo']==1){

    function verificarToken($req,$res){
        try{
            $token = $req['hub_verify_token'];
            $challenge = $req['hub_challenge'];
    
            if (isset($challenge) && isset($token) && $token === TOKEN_ANDERCODE) {
                $res->send($challenge);
            } else {
                $res->status(400)->send();
            }

        }catch(Exception $e){
            $res ->status(400)->send();
        }
    }
    
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
    

    try {
        foreach($datosTabla as $dato){
            $nombre = $dato[0];
            $apellido = $dato[1];
            $telefono = "593".$dato[2];
         $sql = $sql = "INSERT INTO msjwhatsapp(nombre, apellido, telefono, fecha, mensaje, us_id) 
         VALUES(:nombre, :apellido, :telefono, now(), :mensaje, :id_us )";
         $query = $this->acceso->prepare($sql);
         $query->execute(array(
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':telefono' => $telefono,
            ':mensaje' => $mensaje,
            ':id_us' => $id_usuario
         ));
        
         EnviarMensajeWhatsapp($telefono, $mensaje);


        }
         echo "add";
        } catch (Exception $e) {
            echo "no add". $e;
        }
    
    
    }


    function EnviarMensajeWhatsapp($telefono, $mensaje) {
        $data = json_encode([
            "messaging_product" => "whatsapp",    
            "recipient_type"=> "individual",
            "to" => $telefono,
            "type" => "text",
            "text"=> [
                "preview_url" => false,
                "body"=> $mensaje
            ]
        ]);
       
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAhcR77bZCIIBOwvzd2d9EZADmypvQgJOol4tXZCnD1MQlB62UcuRlEGcfgCpZBLWQpn7jEqVxhZCjcVbZBleAiiDP2enwpzH5yRTNHwMM351aYaXlTmiC704UVXsVernjZAr6MDtNJ4eBBxeYRW6fGesY7zwF5pkBO57fhGtnt63buzeHBODlIeA2KSfhY7yv92oH21lIht4ohiuebgVgZD\r\n",
                'content' => $data,
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('https://graph.facebook.com/v18.0/101906169521341/messages', false, $context);  
    
        if ($response === false) {
            echo "Error al enviar el mensaje\n";
        } else {
            echo "Mensaje enviado correctamente\n";
        }
    }



    if ($_SERVER['REQUEST_METHOD']==='POST'){
        $input = file_get_contents('php://input');
        $data = json_decode($input,true);

        // recibirMensajes($data,http_response_code());
        
    }

}