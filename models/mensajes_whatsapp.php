<?php
include_once 'conexion.php';
class msjwha{
    var $objetos;
    public function __construct(){
        $db = new conexion();
        $this->acceso = $db->pdo;
    }

    
    function EnviarMensajeWhatsapp($telefono, $mensaje) {
        $token = 'EAAhcR77bZCIIBO8TG7MmiZBotovHIHEg9dnQZAQcM8IDl2XIiTDvHWlLKUJcp2TyUq30Djc5Pw4v3ZAYSR3ROF0QFP1Lp3aZC4Rv79n4uDgikd5A59Pr50o8A8XZA2M8ZAiDRDp327Gv48oZBrHZAaUgynt83VFGdZB8KFF3NVfF5pfFNlQfPNEPAG3fwGIX7tD2zJbZBK5mCnLg6A1TeZA2esAZD';
        $url = 'https://graph.facebook.com/v18.0/101906169521341/messages';
    
        $mensajeData = json_encode([
            "messaging_product" => "whatsapp",
            "to" => $telefono,
            "type" => "text",
            "text" => [
                "body" => $mensaje
            ]
        ]);
    
        $header = [
            "Authorization: Bearer " . $token,
            "Content-Type: application/json"
        ];
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensajeData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($curl);
    
        if ($response === false) {
            echo "Error en la solicitud cURL: " . curl_error($curl);
        } else {
            $decodedResponse = json_decode($response, true);
    
            if (isset($decodedResponse['error'])) {
                echo "Error en la respuesta: " . $decodedResponse['error']['message'];
            } else {
                echo "Mensaje enviado correctamente";
            }
        }
    
        curl_close($curl);
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


