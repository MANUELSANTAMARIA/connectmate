<?php
include_once 'conexion.php';
class msjwha{
    var $objetos;
    public function __construct(){
        $db = new conexion();
        $this->acceso = $db->pdo;
    }

    
    function EnviarMensajeWhatsapp($mensaje, $telefono){
        $data = json_encode([
            "messaging_product" => "whatsapp",    
            "recipient_type"=> "individual",
            "to" => $telefono,
            "type" => $mensaje,
            "text"=> [
                "preview_url" => false,
                "body"=> "Te amoo"
            ]
        ]);

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAhcR77bZCIIBO8TG7MmiZBotovHIHEg9dnQZAQcM8IDl2XIiTDvHWlLKUJcp2TyUq30Djc5Pw4v3ZAYSR3ROF0QFP1Lp3aZC4Rv79n4uDgikd5A59Pr50o8A8XZA2M8ZAiDRDp327Gv48oZBrHZAaUgynt83VFGdZB8KFF3NVfF5pfFNlQfPNEPAG3fwGIX7tD2zJbZBK5mCnLg6A1TeZA2esAZD\r\n",
                'content' => $data,
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('https://graph.facebook.com/v18.0/101906169521341/messages', false, $context);  

        if ($response === false) {
            throw new Exception("Error al enviar el mensaje\n");
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
         $this->EnviarMensajeWhatsapp($mensaje, $telefono);
        }
         echo "add";
        } catch (Exception $e) {
            echo "no add". $e;
        }
    }



}