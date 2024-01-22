<?php
include_once 'conexion.php';
class msjwha{
    var $objetos;
    public function __construct(){
        $db = new conexion();
        $this->acceso = $db->pdo;
    }

    
    function EnviarMensajeWhatsapp($mensaje, $telefono){
      //TOKEN QUE NOS DA FACEBOOK
      $token = 'EAAhcR77bZCIIBOwvzd2d9EZADmypvQgJOol4tXZCnD1MQlB62UcuRlEGcfgCpZBLWQpn7jEqVxhZCjcVbZBleAiiDP2enwpzH5yRTNHwMM351aYaXlTmiC704UVXsVernjZAr6MDtNJ4eBBxeYRW6fGesY7zwF5pkBO57fhGtnt63buzeHBODlIeA2KSfhY7yv92oH21lIht4ohiuebgVgZD';
    //   //NUESTRO TELEFONO
    //   $telefono = '593989583454';
      //URL A DONDE SE MANDARA EL MENSAJE
      $url = 'https://graph.facebook.com/v18.0/101906169521341/messages';

      //CONFIGURACION DEL MENSAJE
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
     //DECLARAMOS LAS CABECERAS
     $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
    //INICIAMOS EL CURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
   $response = json_decode(curl_exec($curl), true);
  //IMPRIMIMOS LA RESPUESTA 
   print_r($response);
  //OBTENEMOS EL CODIGO DE LA RESPUESTA
  $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  //CERRAMOS EL CURL
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
         $this->EnviarMensajeWhatsapp($telefono);
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