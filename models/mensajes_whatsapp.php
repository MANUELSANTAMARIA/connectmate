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
            $numero = "593".$dato[2];
            $sql = "SELECT * FROM contacto WHERE  numero_contacto = :numero_contacto";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':numero_contacto' => $numero,
            ));
            $this->objetos = $query->fetch();
        if (empty($this->objetos)){
            $sql = "INSERT INTO contacto(numero_contacto, nombre, apellido) VALUES(:numero, :nombre, :apellido)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':numero' => $numero,
                ':nombre' => $nombre,
                ':apellido' => $apellido 
            ));
        }
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

    function conversacion_whatsapp($id, $comentario, $numero, $tipo_mensaje){
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
            $sql = "INSERT INTO conversacion_whatsapp(cod_whatsapp, mensaje, marca_tiempo, numero_contacto, tipo_mensaje_id) VALUES(:cod_whatsapp, :mensaje, now(), :numero, :tipo_mensaje)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':cod_whatsapp'=>$id,
                ':mensaje' => $comentario,
                ':numero' => $numero,
                ':tipo_mensaje' => $tipo_mensaje
            ));

    }

    


}


