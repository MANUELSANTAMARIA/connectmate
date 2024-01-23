<?php
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
        EnviarMensajeWhastapp("593989519807", $tipoMensaje, $mensaje);

    }
    function EnviarMensajeWhastapp($numero, $tipoMensaje, $mensaje){
        if($tipoMensaje == 1){
            $data = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "text",
                "text"=> [
                    "preview_url" => false,
                    "body"=> "Hola visita mi web andercon-bastidas.com"
                ]
            ]);

            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAcohQsYbHEBO4rl7rNPiGjAm54PihExc1D8oQQssTMaus82FKaislVYTC4QsL1xlY1eC9O8BysiCD7JSQ4pbWEQJu2dOt0PrPy7EemIzSvoSztBnDOghkFZAyKiZASjBRqFcyAgHf5TGgljmpdddCZB5oj6sG77jaUb4LHSv50vBwZCZAue7YTMeDdBLY6Kws8hkvBqJiOTeOkZBOyVMZD\r\n",
                    'content' => $data,
                    'ignore_errors' => true
                ]
            ];
        }
    
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

    //   recibirMensajes($data,http_response_code());

    }else if($_SERVER['REQUEST_METHOD']==='GET'){
        if(isset($_GET['hub_mode']) && isset($_GET['hub_verify_token']) && isset($_GET['hub_challenge']) && $_GET['hub_mode'] === 'subscribe' && $_GET['hub_verify_token'] === TOKEN_MANUEL){
        echo $_GET['hub_challenge'];
        }else{
        http_response_code(403);
        }
    }