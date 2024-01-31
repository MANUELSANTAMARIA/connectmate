<?php
    include_once 'models/mensajes_whatsapp.php';
    $msjwhatsapp = new msjwha();
    
    const TOKEN_MANUEL = "MANUELSANTAMARIACHICOANGIELARASSS";
    const WEBHOOK_URL = "https://samperza.com/connectmate/webhook/webhook.php";
    
    function verificarToken($req,$res){
        try{
            // verificar token propio de meta
            $token = $req['hub_verify_token'];
            // verificar challenge propio de meta
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
                $archivo = fopen($archivo, "a");
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
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "text",
                "text"=> [
                    "preview_url" => false,
                    "body"=> "¡Hola! ¿Cómo podemos ayudarte hoy? Si tienes alguna pregunta o necesitas información, no dudes en decírmelo."
                ]
            ]);
        }else if($comentario=='1'){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "document",
                "document"=> [
                    "link" => "https://samperza.com/connectmate/uploads/documento/promociones.pdf",
                    "caption" => "Promociones 🎉"
                ]
            ]);
        }else if($comentario=='2'){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "location",
                "location"=> [
                    "latitude" => "-2.1855857557219434",
                    "longitude" => "-79.88438064938596",
                    "name" => "Manuel Galecio Ligero, Guayaquil 090312",
                    "address" => "CNT COACTIVA"
                ]
            ]);
        }else if($comentario=='3'){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "document",
                "document"=> [
                    "link" => "https://samperza.com/connectmate/uploads/documento/catalogo.pdf",
                    "caption" => "Catálogo de celulares 📄"
                ]
            ]);
        }else if($comentario=='4'){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "text",
                "text"=> [
                    "preview_url" => false,
                    "body"=> "¡Hola! 🌟 Nos alegra informarte que hemos recibido tu mensaje y nos hemos puesto en contacto contigo a través de WhatsApp. Estamos aquí para ayudarte en lo que necesites. ¡Gracias por tu interés en nuestros servicios! 😊📱"
                ]
            ]);

        }else if($comentario=='5'){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "document",
                "document"=> [
                    "link" => "https://samperza.com/connectmate/uploads/documento/internet_telefonia.pdf",
                    "caption" => "planes de internet y telefonia 🌐📞"
                ]
            ]);


        }else if($comentario=='6'){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $numero,
                "type" => "text",
                "text" => array(
                    "preview_url" => false,
                    "body" => "📅 Horario de Atención del local: Lunes a Viernes. \n🕜 Horario: 8:00 a.m. a 5:00 p.m. 🤓"
                )
            ]);

        }else if (strpos($comentario,'adios') !== false || strpos($comentario,'bye') !== false || strpos($comentario,'nos vemos') !== false || strpos($comentario,'adiós') !== false){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $numero,
                "type" => "text",
                "text" => array(
                    "preview_url" => false,
                    "body" => "Hasta luego. 🌟"
                )
            ]);
        }else{
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "text",
                "text"=> [
                    "preview_url" => false,
                    "body"=> "🚀 ¡Hola! Bienvenido a sanlaracode, líder en servicios tecnológicos. Para obtener más información, selecciona una opción:\n \n📌 *Por favor, ingresa un número #️⃣ para recibir información:* .\n \n1️⃣. *Promociones 🎉:* ¿Quieres conocer nuestras ofertas especiales ❔\n2️⃣. *Ubicación del local 📍:* Encuentra nuestra tienda.\n3️⃣. *Catálogo de celulares 📄:* Solicita nuestro catálogo en formato PDF.\n4️⃣. *Hablar con un asesor de ventas 🙋‍♂️:* Conéctate con nuestro equipo de expertos.\n5️⃣.*Información sobre planes de internet y telefonía 🌐📞:* Descubre nuestras opciones.\n6️⃣. *Horarios de atención de la tienda física 🕒:* Conoce nuestros horarios de atención en la tienda."
                ]
            ]);
        }
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAO4RniNZBeUBOzhZCvnqDgaURSsM0J1mSQGvgn3wLChPNauBqi0H9ZAgkzqW4ElPsBkq0eJiPUdlGGnvXjRzQhr3qJ80XoOwwOfQEstJKAoS0w1nqZA2dvPvCKBZCbU5lis8fEGugeSNW1xIngqIZAFq1ZAqbZBd5Qfhakke5P2loJY2Lb3vDS6SAZBBZAx1ZCOFQyeHmduiZB219CEmFSt\r\n",
                'content' => $dataBot,
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('https://graph.facebook.com/v18.0/218219994708699/messages', false, $context);

        if ($response === false) {
            echo "Error al enviar el mensaje\n";
        } else {
            echo "Mensaje enviado correctamente\n";
        }
    }
    
    function verificarTextoEnArchivo($texto, $archivo) {
        $contenido = file_get_contents($archivo);
        
        if (strpos($contenido, $texto) !== false) {
            return true; // El texto ya existe en el archivo
        } else {
            return false; // El texto no existe en el archivo
        }
    }
    

    if ($_SERVER['REQUEST_METHOD']==='POST' && $_POST["funcion"] != "txtwhatsapp"){
        $input = file_get_contents('php://input');
        $dataBot = json_decode($input,true);

        recibirMensajes($dataBot,http_response_code());
        
    }else if($_SERVER['REQUEST_METHOD']==='GET'){
        if(isset($_GET['hub_mode']) && isset($_GET['hub_verify_token']) && isset($_GET['hub_challenge']) && $_GET['hub_mode'] === 'subscribe' && $_GET['hub_verify_token'] === TOKEN_MANUEL){
            echo $_GET['hub_challenge'];
        }else{
            http_response_code(403);
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
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAQCwOGSEvUBO2O1nUQU6TyZBRZCcVM8hyExCh6gi9MHqxZB0s4BQmP1ZBFnXolv4uMsHI5HZBjic0lSJT7YYPZAZCzGNc4ajINhIUK2z5XhWlwzkri8g0IvoPmnMPAEe22EbM3qOLEJREm9a2KcyJ9WM97fLlOkcZCckfOGqA32pZCB0AHgZBnHgaMtkLoTthWY78LRyly4rS2RIvY308\r\n",
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


    if($_POST["funcion"] == "txtwhatsapp"){
        // echo json_encode(["status" => "exit"]); 
        // echo json_encode($data["datosTabla"]);
    
        $datosTabla = $_POST["datosTabla"];
        $tipoMensaje = $_POST["tipo_mensaje"];
        $mensaje = $_POST["descripcion"];
        $mensaje = $_POST["descripcion"];
        $id_usuario = $_POST["usuario"];
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

?>