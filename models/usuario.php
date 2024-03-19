<?php

include_once 'conexion.php';
class usuario
{
  var $objetos;
  public function __construct()
  {
    $db = new conexion();
    $this->acceso = $db->pdo;
  }

  function loguearse($email, $pass)
  {
    $sql = "SELECT * FROM usuario
        INNER JOIN tipo_usuario on usuario.tipo_us_id = tipo_usuario.id_tipo_us
        INNER JOIN estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
        WHERE email_us =:email";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':email' => $email));
    $usuario = $query->fetch(PDO::FETCH_ASSOC); // Establecer FETCH_ASSOC para obtener un array asociativo
    
     // Verificar si se encontró un usuario con el correo electrónico dado
     if ($usuario) {
      // Verificar si la contraseña proporcionada coincide con la contraseña almacenada
      if (password_verify($pass, $usuario['contrasena_us'])) {
          // Si la contraseña coincide, devolver el objeto de usuario
          return $usuario;
      } else {
          // Si la contraseña no coincide, devolver false indicando una contraseña incorrecta
          return false;
      }
  } else {
      // Si no se encontró ningún usuario con el correo electrónico dado, devolver false
      return false;
  }
    
  }


  function cambiar_contra($oldpass, $newpass, $id_usuario)
  {
    $sql = "SELECT * FROM usuario where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario));
    $this->objetos = $query->fetch();
    if (!empty($this->objetos) && password_verify($oldpass, $this->objetos->contrasena_us)) {
      $contraseña_segura = password_hash($newpass, PASSWORD_BCRYPT, ['cost' => 4]);
      $sql = "UPDATE usuario SET contrasena_us=:newpass where id_us=:id";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id' => $id_usuario, ':newpass' => $contraseña_segura));
      echo 'update';
    } else {
      echo 'noupdate';
    }
  }

  // datos personales
  function dato_usuario($id)
  {
    $sql = "SELECT * FROM usuario
        INNER JOIN tipo_usuario on usuario.tipo_us_id = tipo_usuario.id_tipo_us
        INNER JOIN estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
        and id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id));
    $this->objetos = $query->fetchall();
    return $this->objetos;
  }

  function buscar_avatar_usuario($id_usuario)
  {
    try {
      $sql = "SELECT avatar FROM usuario WHERE id_us = :id_us";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id_us' => $id_usuario));
      $resultado = $query->fetchColumn();
      if ($resultado !== false) {
        return $resultado;
      } else {
        return "imgavatar.png";
      }
    } catch (PDOException $e) {
      // En lugar de imprimir un mensaje de error, podrías manejarlo de alguna otra manera (log, notificación, etc.)
      return "Error en la consulta: " . $e->getMessage();
    }
  }

  function cambiar_avatar($id_usuario, $nombre)
  {
    $sql = "SELECT avatar FROM usuario where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario));
    $this->objetos = $query->fetchall();

    $sql = "UPDATE usuario SET avatar=:nombre where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario, ':nombre' => $nombre));
    return $this->objetos;
  }

  // tipos de usuario
  function tipo_usuario()
  {
    $sql = "SELECT * FROM tipo_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute();
    $this->objetos = $query->fetchall();
    return $this->objetos;
  }
  // gestinar usuario 
  function crear($nombre, $apellido, $fechaNacimiento, $ci, $correo, $contrasena, $tipo, $habilitado, $avatar_defecto)
  {
    $sql = "SELECT * FROM usuario WHERE email_us = :email";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':email' => $correo));
    $this->objetos = $query->fetchAll();

    if (!empty($this->objetos)) {
      return 'noadd';
    } else {
      // Cifrar la contraseña
      $contrasena_segura = password_hash($contrasena, PASSWORD_BCRYPT, ['cost' => 4]);
      $sql = "INSERT INTO usuario(nombre_us, apellido_us, edad_us, ci_us, email_us, contrasena_us, tipo_us_id, estado_us_id, avatar, creado_en) 
            VALUES(:nombre, :apellido, :fechaNacimiento, :ci_us, :correo, :contrasena, :tipo, :estado_usuario, :avatar, now())";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':fechaNacimiento' => $fechaNacimiento,
        ':ci_us' => $ci,
        ':correo' => $correo,
        ':contrasena' => $contrasena_segura,
        ':tipo' => $tipo,
        ':estado_usuario' => $habilitado,
        ':avatar' => $avatar_defecto
      ));

      return 'add';
    }
  } //fin de crear usuario



  function buscar()
  {
    // si teclea  que se muestre el usuario buscar
    if (!empty($_POST['consulta'])) {
      $consulta = $_POST['consulta'];
      $sql = "SELECT * FROM usuario 
           JOIN tipo_usuario ON tipo_us_id = id_tipo_us
           JOIN estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
           WHERE nombre_us LIKE :consulta  OR apellido_us LIKE :consulta";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':consulta' => "%$consulta%"));
      $this->objetos = $query->fetchall();
      return $this->objetos;
    } else {
      $sql = "SELECT * FROM usuario 
            JOIN tipo_usuario on tipo_us_id = id_tipo_us 
            JOIN estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
            WHERE nombre_us NOT LIKE '' ORDER BY id_us LIMIT 25";
      $query = $this->acceso->prepare($sql);
      $query->execute();
      $this->objetos = $query->fetchall();
      return $this->objetos;
    }
  }

  //deshabilitar_usuario
  function deshabilitar_usuario($pass, $id_deshabilitar, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario where id_us=:id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();

    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $habilitado = 2;
      $sql = "UPDATE usuario SET estado_us_id = :habilitado where id_us=:id";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id' => $id_deshabilitar, ':habilitado' => $habilitado));
      echo 'deshabilitado';
    } else {
      echo 'nodeshabiltado';
    }
  }

  // habilitar usuario
  function habilitar_usuario($pass, $id_habilitar, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario where id_us=:id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();
    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $habilitado = 1;
      $sql = "UPDATE usuario SET estado_us_id =:habilitado where id_us=:id";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id' => $id_habilitar, ':habilitado' => $habilitado));
      echo 'habilitado';
    } else {
      echo 'nohabiltado';
    }
  }

  // borrar usuario
  function borrar($pass, $id_borrado, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario WHERE id_us = :id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();
    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $sql = "DELETE FROM usuario WHERE id_us = :id_borrado";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id_borrado' => $id_borrado));
      echo 'borrado';
    } else {
      echo 'noborrado';
    }
  } //fin de borrar usuario

}
