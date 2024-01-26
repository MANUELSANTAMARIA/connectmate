<?php
    // include_once 'models/mensajes_whatsapp.php';
    // $msjwhatsapp = new msjwha();
    
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
             
            $entry = $req['entry'][0];
            $changes = $entry['changes'][0];
            $value = $changes['value'];
            $mensaje = $value['messages'][0];
            
            $comentario = $mensaje['text']['body'];
            $numero = $mensaje['from'];
            
            $id = $mensaje['id'];
            
            $archivo = "log.txt";
            
            if (!verificarTextoEnArchivo($id, $archivo)) {
                $archivo = fopen($archivo, "a+");
                $texto = json_encode($id).",".$numero.",".$comentario;
                fwrite($archivo, $texto);
                fclose($archivo);
                
                whatsappBot($comentario,$numero);
            }
            
            $res->header('Content-Type: application/json');
            $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));

        } catch (Exception $e) {
            $res->header('Content-Type: application/json');
            $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));
        }
    }


    function whatsappBot($comentario,$numero){
        $comentario = strtolower($comentario);

        if (strpos($comentario,'hola') !==false){
            $data = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "text",
                "text"=> [
                    "preview_url" => false,
                    "body"=> "1.- precios de telefonos"
                ]
            ]);
        }

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAcohQsYbHEBOxPkLRQH6qNs1DuFImm1fMabcMkuZC9lHToh1tpp3ErXVVkcFpoC4hfDews49CJpzEKmq38Iu917z6QhqasorqLovyUcTxOEKNUmYOz0ttZBcclhtnd9l0gXQoVIceMzxC07DfLMD3l6sZA5UisUC0SMjdIDCZBixp6n0nbwdFGMtknRl4Ul8TcgBYOwZBc9wkaqQsZAoKAYX0J1O7y6bCjTMZD\r\n",
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
  
        recibirMensajes($data,http_response_code());
  
    }else if($_SERVER['REQUEST_METHOD']==='GET'){
          if(isset($_GET['hub_mode']) && isset($_GET['hub_verify_token']) && isset($_GET['hub_challenge']) && $_GET['hub_mode'] === 'subscribe' && $_GET['hub_verify_token'] === TOKEN_MANUEL){
          echo $_GET['hub_challenge'];
          }else{
          http_response_code(403);
          }
    }

    // // Obtener los datos JSON desde la solicitud
    // $json_data = file_get_contents("php://input");

    // // Decodificar los datos JSON
    // $data = json_decode($json_data, true);
    // if($data["funcion"] == "txtwhatsapp"){
    //     // echo json_encode(["status" => "exit"]); 
    //     // echo json_encode($data["datosTabla"]);
    
    //     $datosTabla = $data["datosTabla"];
    //     $tipoMensaje = $data["tipo_mensaje"];
    //     $mensaje = $data["descripcion"];
    //     $mensaje = $data["descripcion"];
    //     $id_usuario = $data["usuario"];
    //     $contadorIteraciones = 0;
    //     try {
    //         foreach($datosTabla as $dato){
    //             $nombre = $dato[0];
    //             $apellido = $dato[1];
    //             $telefono = "593".$dato[2];

    //             EnviarMensajeWhastapp($telefono, $tipoMensaje, $nombre, $apellido, $mensaje);
                
    //             $contadorIteraciones++;

    //             if ($contadorIteraciones >= 200) {
    //                 break; // Sale del bucle después de 200 iteraciones
    //             }
    //         }
    //         $msjwhatsapp->msjwhatsapp($datosTabla, $tipoMensaje, $mensaje, $id_usuario);
    //     }catch (Exception $e){
    //         echo "noadd". $e;
    //     }
            

    // }


    // function EnviarMensajeWhastapp($telefono, $tipoMensaje, $nombre, $apellido, $mensaje){
    //     if($tipoMensaje == 1){
    //         $unionmensaje = "Hola ".$nombre." ".$apellido." ".$mensaje;
    //         $data = json_encode([
    //             "messaging_product" => "whatsapp",    
    //             "recipient_type"=> "individual",
    //             "to" => $telefono,
    //             "type" => "text",
    //             "text"=> [
    //                 "preview_url" => false,
    //                 "body"=> $unionmensaje
    //             ]
    //         ]);
    //     }
    //         $options = [
    //             'http' => [
    //                 'method' => 'POST',
    //                 'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAcohQsYbHEBO1jVFO8ZAT2pZBoHhUQOYxAWBy2d4tcM3ZBUdLnKhNTvPxNK6iqV4cIcPKQWNSk9Y7D0vOqsTB0YGMKPlsPU23lysZCcrX2YZA6xMQ8XSkWkULzQtagjUNv6c21hJsBxMfFBfpeZCMF1rOmX7WTWKddaiqwCv9ZBb65uaoxONl7ZB1kqwak65oxfK59X7iOSeDp35YNm\r\n",
    //                 'content' => $data, 
    //                 'ignore_errors' => true
    //             ]
    //         ];
        
    
    //         $context = stream_context_create($options);
    //         $response = file_get_contents('https://graph.facebook.com/v18.0/218219994708699/messages', false, $context);
    
    //         if ($response === false) {
    //             // echo "Error al enviar el mensaje\n";
    //         } else {
    //             // echo "Mensaje enviado correctamente\n";
    //         }

    // }



    