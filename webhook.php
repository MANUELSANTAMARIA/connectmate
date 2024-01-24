<?php
    include_once 'models/mensajes_whatsapp.php';
    $msjwhatsapp = new msjwha();
    
    const TOKEN_MANUEL = "MANUELSANTAMARIACHICOANGIELARA";
    const WEBHOOK_URL = "https://samperza.com/connectmate/webhook.php";


    function verificarToken($req,$res){
        try{
            $token = $req['hub_verify_token'];
            $challenge = $req['hub_challenge'];
    
            if (isset($challenge) && isset($token) && $token === TOKEN_MANUEL) {
                $res->send($challenge);
            } else {
                $res->status(400)->send();
            }

        }catch(Exception $e){
            $res ->status(400)->send();
        }
    }

    function recibirMensajes($req, $res) {
        
        try {
            
            $res->header('Content-Type: application/json');
            $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));

        } catch (Exception $e) {
            $res->header('Content-Type: application/json');
            $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));
        }
    }


    // Obtener los datos JSON desde la solicitud
    $json_data = file_get_contents("php://input");

    // Decodificar los datos JSON
    $data = json_decode($json_data, true);
    if($data["funcion"] == "txtwhatsapp"){
        // echo json_encode(["status" => "exit"]); 
        // echo json_encode($data["datosTabla"]);
    
        $datosTabla = $data["datosTabla"];
        $tipoMensaje = $data["tipo_mensaje"];
        $mensaje = $data["descripcion"];
        $mensaje = $data["descripcion"];
        $id_usuario = $data["usuario"];
        $contadorIteraciones = 0;
        try {
            foreach($datosTabla as $dato){
                $nombre = $dato[0];
                $apellido = $dato[1];
                $telefono = "593".$dato[2];

                EnviarMensajeWhastapp($telefono, $tipoMensaje, $nombre, $apellido, $mensaje);
                
                $contadorIteraciones++;

                if ($contadorIteraciones >= 200) {
                    break; // Sale del bucle después de 200 iteraciones
                }
            }
            $msjwhatsapp->msjwhatsapp($datosTabla, $tipoMensaje, $mensaje, $id_usuario);
        }catch (Exception $e){
            echo "noadd". $e;
        }
            

    }


    function EnviarMensajeWhastapp($telefono, $tipoMensaje, $nombre, $apellido, $mensaje){
        if($tipoMensaje == 1){
            $unionmensaje = "Hola ".$nombre." ".$apellido." ".$mensaje;
            $data = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $telefono,
                "type" => "text",
                "text"=> [
                    "preview_url" => false,
                    "body"=> $unionmensaje
                ]
            ]);
        }
            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAcohQsYbHEBO7bLnIs6lhkg926xBGGd0yiAZAaJ4gtCfmdPiUk6XkpHDzqPyHVuekJGEaxKZBGwfey8V6FPZAZB4FkpnDGs4pTSaQCnf2Eo9KXgiavL1bsmPn0BBatkZAnSlzWpxZAaP0NLCrMtZCNKfwZCrr8JJRQk7a2KZAY4iEASX0EokavGUMgyMONljz4PQgQ3I0qJ9fK6RoTIxsH4ZD\r\n",
                    'content' => $data, 
                    'ignore_errors' => true
                ]
            ];
        
    
            $context = stream_context_create($options);
            $response = file_get_contents('https://graph.facebook.com/v18.0/101906169521341/messages', false, $context);
    
            if ($response === false) {
                // echo "Error al enviar el mensaje\n";
            } else {
                // echo "Mensaje enviado correctamente\n";
            }

    }



    if ($_SERVER['REQUEST_METHOD']==='POST'){
      $input = file_get_contents('php://input');
      $data = json_decode($input,true);

    //   recibirMensajes($data,http_response_code());

    }else if($_SERVER['REQUEST_METHOD']==='GET'){
        if(isset($_GET['hub_mode']) && isset($_GET['hub_verify_token']) && isset($_GET['hub_challenge']) && $_GET['hub_mode'] === 'subscribe' && $_GET['hub_verify_token'] === TOKEN_MANUEL){
        echo $_GET['hub_challenge'];
        }else{
        http_response_code(403);
        }
    }