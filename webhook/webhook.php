<?php
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
                whatsappBot($id, $comentario, $numero);
                
                if($_POST["funcion"] != "txtwhatsapp"){
                    include_once '../models/mensajes_whatsapp.php';
                    $msjwhatsapp = new msjwha();
                    $msjwhatsapp->conversacion_whatsapp($id, $comentario, $numero);
                }

            }
            
            $res->header('Content-Type: application/json');
            $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));

        } catch (Exception $e) {
            $res->header('Content-Type: application/json');
            $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));
        }
    }
    
    function whatsappBot($id, $comentario, $numero){
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
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAO4RniNZBeUBO3w4lCPxyS4vYAnbxuV763pHI0K8BCwns5xiDLbdYmukDXlvMTu3vDzXyTJ6A5G8C7wun8XgAz5Gx1ue2ADoCmFW82lYJRhn2XnfCAj4saGEdFwjKZB8qj4ZClc646vdDk6RUrwrB0Fa13SD0nQ5OUCQsJ6o1840pFVhXMCXGu4jb90IflNnyLndPfZBXZBTFcad\r\n",
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





    function EnviarMensajeWhastapp($telefono, $tipoMensaje, $nombre, $apellido, $mensaje, $nombreUnico = null){
        if($tipoMensaje == "1"){
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
        }if($tipoMensaje == "2"){
            $data = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $telefono,
                "type" => "image",
                "image"=> [
                    "link" => "https://samperza.com/connectmate/uploads/img-enviar-whatsapp/".$nombreUnico,
                    "caption" => "Hola ".$nombre." ".$apellido." ".$mensaje,
                ]
            ]);
        }
        if($tipoMensaje == "3"){
            $data = json_encode([
                "messaging_product" => "whatsapp",    
                "recipient_type"=> "individual",
                "to" => $telefono,
                "type" => "document",
                "document"=> [
                    "link" => "https://samperza.com/connectmate/uploads/pdf-enviar-whatsapp/".$nombreUnico,
                    "caption" => "Hola ".$nombre." ".$apellido." ".$mensaje,
                ]
            ]);
        }
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAO4RniNZBeUBO3w4lCPxyS4vYAnbxuV763pHI0K8BCwns5xiDLbdYmukDXlvMTu3vDzXyTJ6A5G8C7wun8XgAz5Gx1ue2ADoCmFW82lYJRhn2XnfCAj4saGEdFwjKZB8qj4ZClc646vdDk6RUrwrB0Fa13SD0nQ5OUCQsJ6o1840pFVhXMCXGu4jb90IflNnyLndPfZBXZBTFcad\r\n",
                'content' => $data,
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('https://graph.facebook.com/v18.0/218219994708699/messages', false, $context);

        // if ($response === false) {
        //     echo "Error al enviar el mensaje\n";
        // } else {
        //     echo "Mensaje enviado correctamente\n";
        // }

    }


    if($_POST["funcion"] == "txtwhatsapp"){
            include_once '../models/mensajes_whatsapp.php';
            $msjwhatsapp = new msjwha();

            // Obtener los datos enviados desde el formulario
            $datosTablaJSON = $_POST['datosTabla'];
            $tipoMensaje = $_POST["tipo_mensaje"];
            $mensaje = $_POST["descripcion"];
            $id_usuario = $_POST["usuario"];
            // Decodificar los datos JSON en un array PHP
            $datosTabla = json_decode($datosTablaJSON);
            if($tipoMensaje == "1"){
                $contadorIteraciones = 0;
                try {
                    foreach($datosTabla as $dato){
                        $nombre = $dato[0];
                        $apellido = $dato[1];
                        $telefono = "593" . $dato[2];

                    // Llamar a la función para enviar mensajes de WhatsApp
                    EnviarMensajeWhastapp($telefono, $tipoMensaje, $nombre, $apellido, $mensaje);

                    $contadorIteraciones++;

                        if ($contadorIteraciones >= 200) {
                            break; // Salir del bucle después de 200 iteraciones
                        }
                    }
                } catch (Exception $e){
                    echo "noadd" . $e;
                }
            } else if($tipoMensaje == "2"){
                 // Procesar la imagen
                if(isset($_FILES['img_whatsapp'])) {
                    $archivo = $_FILES['img_whatsapp'];

                    // Acceder a las propiedades del archivo
                    $nombreArchivo = $archivo['name'];
                    $tipoArchivo = $archivo['type'];
                    $tamanioArchivo = $archivo['size'];
                    $rutaTemporal = $archivo['tmp_name'];
                    $errorArchivo = $archivo['error'];
                    if(($tipoArchivo == 'image/jpeg') || $tipoArchivo == "image/jpg" || ($tipoArchivo == 'image/png') || ($tipoArchivo == 'image/gif')) {
                        // antes de todos tu ruta donde vas guardar file deben tener permisos en servidor
                        // -R:recursivo, lo que significa que los permisos se aplicarán a todos los archivos y subdirectorios dentro de 
                        // sudo chmod 777 /var/www/sanperza.com/connectmate/uploads
                        // creo la carpeta si no existe
	                  if(!is_dir('../uploads/img-enviar-whatsapp')){
		                mkdir('../uploads/img-enviar-whatsapp', 0777, true);
                      }else {
                        chmod('../uploads/img-enviar-whatsapp', 0777, true);
                      }
                        // generar un nombre de archivo único 
                        $nombreUnico = uniqid() . '-' .$nombreArchivo;
                         
                        // Mover el archivo a su ubicación deseada
                        $rutaDestino = "../uploads/img-enviar-whatsapp/".$nombreUnico;

                        // utiliza para mover un archivo cargado (subido) desde una ubicación temporal a una ubicación permanente en el servidor
                        move_uploaded_file($rutaTemporal, $rutaDestino);
                        
                        $contadorIteraciones = 0;
                        try {
                            foreach($datosTabla as $dato){
                                $nombre = $dato[0];
                                $apellido = $dato[1];
                                $telefono = "593" . $dato[2];
                                EnviarMensajeWhastapp($telefono, $tipoMensaje, $nombre, $apellido, $mensaje, $nombreUnico);
                                
                                $contadorIteraciones++;
                                if ($contadorIteraciones >= 200) {
                                    break; // Salir del bucle después de 200 iteraciones
                                }
                            }
                            
                        } catch (Exception $e){
                            echo "noadd" . $e;
                        }
                      
                    }
                   
                } 
            } else if($tipoMensaje == "3"){
                if(isset($_FILES['doc_whatsapp'])) {
                    $archivo = $_FILES['doc_whatsapp'];
                    // var_dump($_FILES['pdf_whatsapp']);
                    // Acceder a las propiedades del archivo
                    $nombreArchivo = $archivo['name'];
                    $tipoArchivo = $archivo['type'];
                    $tamanioArchivo = $archivo['size'];
                    $rutaTemporal = $archivo['tmp_name'];
                    $errorArchivo = $archivo['error'];
                        // Antes de todos, asegúrate de que la carpeta donde guardarás los archivos tenga permisos en el servidor
                        // -R: recursivo, lo que significa que los permisos se aplicarán a todos los archivos y subdirectorios dentro de 
                        // sudo chmod 777 -R /var/www/sanperza.com/connectmate/uploads
                        // Creo la carpeta si no existe
                        
                        if(!is_dir('../uploads/doc-enviar-whatsapp')) {
                            mkdir('../uploads/doc-enviar-whatsapp', 0777, true);
                        } 
                        // Generar un nombre de archivo único 
                        $nombreUnico = uniqid() . '-' . $nombreArchivo;
                        
                        
                         // Mover el archivo a su ubicación deseada
                         $rutaDestino = "../uploads/doc-enviar-whatsapp/".$nombreUnico;

                         // utiliza para mover un archivo cargado (subido) desde una ubicación temporal a una ubicación permanente en el servidor
                         move_uploaded_file($rutaTemporal, $rutaDestino);
                
                        $contadorIteraciones = 0;
                        try {
                            foreach($datosTabla as $dato) {
                                $nombre = $dato[0];
                                $apellido = $dato[1];
                                $telefono = "593" . $dato[2];
                                EnviarMensajeWhastapp($telefono, $tipoMensaje, $nombre, $apellido, $mensaje, $nombreUnico);
                                
                                $contadorIteraciones++;
                                if ($contadorIteraciones >= 200) {
                                    break; // Salir del bucle después de 200 iteraciones
                                }
                            }
                        } catch (Exception $e) {
                            echo "noadd" . $e;
                        }
                }                

            }
    }



?>