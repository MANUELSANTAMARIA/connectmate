<?php
include_once 'conexion.php';
class msjwha{
    var $objetos;
    public function __construct(){
        $db = new conexion();
        $this->acceso = $db->pdo;
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
    
    

    function msjwhatsapp($datosTabla, $tipoMensaje, $mensaje, $id_usuario){   
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
         $this->EnviarMensajeWhatsapp($telefono, $mensaje);
        }
         echo "add";
        } catch (Exception $e) {
            echo "no add". $e;
        }
    }



}


