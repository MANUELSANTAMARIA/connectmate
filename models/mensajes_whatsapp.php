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
            return "add";
        } catch (Exception $e) {
            return "noadd". $e;
        }
    }

    function conversacion_whatsapp($id, $comentario, $numero){
        $sql = "SELECT * FROM contacto WHERE  numero_contacto = :numero_contacto";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':numero_contacto' => $numero,
        ));
        $this->objetos = $query->fetch();
        if (empty($this->objetos)){
            $sql = "INSERT INTO contacto(numero_contacto) VALUES(:numero)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':numero' => $numero
            ));
        }
            

            $sql = "INSERT INTO conversacion_whatsapp(cod_whatsapp, mensaje, marca_tiempo, numero_contacto) VALUES(:cod_whatsapp, :mensaje, now(), :numero)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':cod_whatsapp'=>$id,
                ':mensaje' => $comentario,
                ':numero' => $numero
            ));



        

    }

    


}


