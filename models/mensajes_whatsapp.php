<?php
include_once 'conexion.php';
class msjwha{
    var $objetos;
    public function __construct(){
        $db = new conexion();
        $this->acceso = $db->pdo;
    }

    
    function msjwhatsapp($datosTabla, $tipoMensaje, $mensaje, $id_usuario){   
        try {
        foreach($datosTabla as $dato){
            $nombre = $dato[0];
            $apellido = $dato[1];
            $telefono = "593".$dato[2];
         $sql = "INSERT INTO msjwhatsapp(nombre, apellido, telefono, fecha, mensaje, us_id) 
         VALUES(:nombre, :apellido, :telefono, now(), :mensaje, :id_us )";
         $query = $this->acceso->prepare($sql);
         $query->execute(array(
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':telefono' => $telefono,
            ':mensaje' => $mensaje,
            ':id_us' => $id_usuario
         ));
        }
            echo "add";
        } catch (Exception $e) {
            echo "noadd". $e;
        }
    }



    function varificaridjwhatsapp($id, $numero, $mensaje){
        $sql = "SELECT * FROM conversacion_whatsapp WHERE cod_whatsapp = :cod_whatsapp";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':cod_whatsapp' => $id,
        ));
        $this->objetos = $query->fetch();
        if (!empty($this->objetos)){
            echo "add";
        }else{
            echo"noadd";
        }
    }


}


