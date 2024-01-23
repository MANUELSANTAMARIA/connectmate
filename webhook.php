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
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAhcR77bZCIIBO5tj03MflfPZBxW1ivr7Ls15tvnZBqa39TiNa8dF9XT628eUOfQRD9eZAZCBZCSoXp4K4tkRvJnVJFUPT5mratFfoJ0PZCaIlBuCDSuF7iEuPMfnbQHPFcyO2Uf3P8DMmbkYovSKvmEFZBelRk48zZAwVTppgzsLzJikLSFqeiMVMAGj3nNVQYZCpWAylIpXoyqm4HUK8bT0ZD\r\n",
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