<?php
    include_once 'models/mensajes_whatsapp.php';
    $msjwhatsapp = new msjwha();
    
    const TOKEN_MANUEL = "MANUELSANTAMARIACHICOANGIELARA";
    const WEBHOOK_URL = "https://samperza.com/connectmate/webhook.php";


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
                $archivo = fopen($archivo, "a+");
                $texto = json_encode($id).",".$numero.",".$comentario;
                fwrite($archivo, $texto);
                fclose($archivo);
                
                EnviarMensajeWhastapp($comentario,$numero);
            }
    
            $res->header('Content-Type: application/json');
            $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));

        } catch (Exception $e) {
            $res->header('Content-Type: application/json');
            $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));
        }
    }
    
    function EnviarMensajeWhastapp($comentario,$numero){
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
                    "link" => "http://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf",
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
                    "latitude" => "-2.1855107085025343",
                    "longitude" => "-79.88436992054966",
                    "name" => "Manuel Galecio Ligero, Guayaquil 090312",
                    "address" => "Manuel Galecio Ligero, Guayaquil 090312"
                ]
            ]);
        }else if($comentario=='3'){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "document",
                "document"=> [
                    "link" => "http://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf",
                    "caption" => "Catálogo de celulares 📄"
                ]
            ]);
        }else if($comentario=='4'){


        }else if($comentario=='5'){
            $dataBot = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $numero,
                "type" => "document",
                "document"=> [
                    "link" => "http://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf",
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
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAcohQsYbHEBO4gSYdRZAbluVQLovpGhZAHj9a8Sz0UJdMjZBhddZCZAY7VIsi2n2riMyXrCZBLav7dCokQiXgSPvreZCi8ZBqoiBjQgk2fSnvZAbNLe4fCzkXu3o6lhP0hr4TpwTY98jybMBAeN1sEGQfDkqJNOpkMwNgpta9ecOZAh627POuquERvbZA7KDrajpBW7C1ARvzt8hYW1TOE\r\n",
                'content' => $dataBot,
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
    
    function verificarTextoEnArchivo($texto, $archivo) {
        $contenido = file_get_contents($archivo);
        
        if (strpos($contenido, $texto) !== false) {
            return true; // El texto ya existe en el archivo
        } else {
            return false; // El texto no existe en el archivo
        }
    }
    

    if ($_SERVER['REQUEST_METHOD']==='POST'){
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
?>