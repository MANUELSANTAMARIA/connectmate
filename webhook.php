<?php
    const TOKEN_ANDERCODE = "MANUELCHICOSANTASANTA";
    const WEBHOOK_URL = "https://samperza.com/connectmate/webhook.php";

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

    
    // EnviarMensajeWhastapp("593989519807");

    function EnviarMensajeWhastapp($numero){
        // $comentario = strtolower($comentario);
        $data = json_encode([
            "messaging_product" => "whatsapp",    
            "recipient_type"=> "individual",
            "to" => $numero,
            "type" => "text",
            "text"=> [
                "preview_url" => false,
                "body"=> "Te amoo"
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