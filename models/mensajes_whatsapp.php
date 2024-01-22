<?php
include_once 'conexion.php';
class msjwha{
    var $objetos;
    public function __construct(){
        $db = new conexion();
        $this->acceso = $db->pdo;
    }

    
    function EnviarMensajeWhatsapp($telefono, $mensaje){
        // TOKEN QUE NOS DA FACEBOOK
        $token = 'EAAhcR77bZCIIBO8TG7MmiZBotovHIHEg9dnQZAQcM8IDl2XIiTDvHWlLKUJcp2TyUq30Djc5Pw4v3ZAYSR3ROF0QFP1Lp3aZC4Rv79n4uDgikd5A59Pr50o8A8XZA2M8ZAiDRDp327Gv48oZBrHZAaUgynt83VFGdZB8KFF3NVfF5pfFNlQfPNEPAG3fwGIX7tD2zJbZBK5mCnLg6A1TeZA2esAZD';
        // URL A DONDE SE MANDARA EL MENSAJE
        $url = 'https://graph.facebook.com/v18.0/101906169521341/messages';
    
        // CONFIGURACION DEL MENSAJE EN FORMATO JSON
        $mensaje = ''
        . '{'
        . '"messaging_product": "whatsapp", '
        . '"to": "'.$telefono.'", '
        . '"type": "template", '
        . '"template": '
        . '{'
        . '     "name": "hello_world",'
        . '     "language":{ "code": "en_US" } '
        . '} '
        . '}';
    
        // DECLARAMOS LAS CABECERAS
        $header = array("Authorization: Bearer " . $token, "Content-Type: application/json");
        
        // INICIAMOS EL CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        // OBTENEMOS LA RESPUESTA DEL ENVÍO DE INFORMACIÓN
        $response = json_decode(curl_exec($curl), true);
        
        // IMPRIMIMOS LA RESPUESTA
        print_r($response);
        
        // OBTENEMOS EL CÓDIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // CERRAMOS EL CURL
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



if ($_SERVER['REQUEST_METHOD']==='POST'){
    $input = file_get_contents('php://input');
    $data = json_decode($input,true);

    // recibirMensajes($data,http_response_code());
    
}