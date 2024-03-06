<?php 
include_once '../models/usuario.php';
$usuario = new usuario();
session_name("connectmate");
session_start();
$id_usuario = $_SESSION["usuario"];

// cambiar contraseña
if($_POST['funcion']=='cambiar_contra'){
 $oldpass = filter_input(INPUT_POST, 'oldpass', FILTER_SANITIZE_STRING);
 $newpass = filter_input(INPUT_POST, 'newpass', FILTER_SANITIZE_STRING);
 $newpass=$_POST['newpass'];
 $usuario->cambiar_contra($oldpass,$newpass,$id_usuario);
    
}



// buscar usuario actual
if($_POST['funcion']=='dato_usuario'){
    $json=array();
    $fecha_actual = new DateTime();
    $usuario->dato_usuario($_POST['dato']);
    foreach ($usuario->objetos as $objeto) { 
     $nacimiento = new DateTime($objeto->edad_us);
     $edad=$nacimiento->diff($fecha_actual);
     $edad_years = $edad->y;
     $json[]=array(
      'id_us'=>$objeto->id_us,   
      'nombres'=>$objeto->nombre_us,
      'apellidos'=>$objeto->apellido_us,
      'edad'=>$edad_years,
      'ci'=>$objeto->ci_us,
      'correo'=>$objeto->email_us,
      'nombre_tipo'=>$objeto->nombre_tipo_us,
      'tipo_us_id'=>$objeto->tipo_us_id,  
      'nombre_estado_usuario'=>$objeto->nombre_estado_us,
      'avatar'=>$objeto->avatar
     );  
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}



// cambiar avatar
if($_POST['funcion'] == 'cambiar_avatar'){
    if(($_FILES['avatar']['type'] == 'image/jpeg') || $_FILES['avatar']['type'] == "image/jpg" || ($_FILES['avatar']['type'] == 'image/png') || ($_FILES['avatar']['type'] == 'image/gif')) {
        // generar un nombre de archivo único 
        $nombre = uniqid() . '-' . $_FILES['avatar']['name'];

       // ruta donde se va guardar los archivo
       $ruta='../uploads/avatar/'.$nombre;
        
       // utiliza para mover un archivo cargado (subido) desde una ubicación temporal a una ubicación permanente en el servidor
       move_uploaded_file($_FILES['avatar']['tmp_name'], $ruta);
       $usuario->cambiar_avatar($id_usuario, $nombre);
       
        foreach ($usuario->objetos as $objeto) {
            if($objeto->avatar != "imgavatar.png"){
                if(file_exists('../uploads/avatar/'.$objeto->avatar)){
                // se utiliza para eliminar un archivo del sistema de archivos del servido
                unlink('../uploads/avatar/'.$objeto->avatar);
                }
            }
        }
       
      $json= array();
      $json[]=array(
      'ruta'=>$ruta,
      'alert'=>'edit'
      );
      $jsonstring = json_encode($json[0]);
      echo $jsonstring;
    
    }else{
        $json= array();
        $json[]=array(
        'alert'=>'noedit'
        );
         $jsonstring = json_encode($json[0]);
        echo $jsonstring;
     }
}



// tipos de usuario
if($_POST["funcion"] == "tipos_usuario"){
    $json = array();
    $usuario->tipo_usuario();
    foreach ($usuario->objetos as $objeto) {
        $json[] = array(
            'id_tipo_us' => $objeto->id_tipo_us,
            'nombre_tipo_us' => $objeto->nombre_tipo_us
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// buscar usuarios
if($_POST['funcion'] == 'buscar_usuarios'){
    $json = array();
    $usuario->buscar();
    foreach($usuario -> objetos as $objeto){
        $json[]=array(
            'id_us'=>$objeto->id_us,   
            'nombres'=>$objeto->nombre_us,
            'apellidos'=>$objeto->apellido_us,
            'ci'=>$objeto->ci_us,
            'correo'=>$objeto->email_us,
            'nombre_tipo'=>$objeto->nombre_tipo_us,
            'tipo_us_id'=>$objeto->tipo_us_id, 
            'nombre_estado_us'=>$objeto->nombre_estado_us,
            'avatar'=>$objeto->avatar
        );
    }

  $jsonstring = json_encode($json);
  echo $jsonstring;

}





// buscar avatar del usuario
if($_POST['funcion'] == 'buscar_avatar_usuario'){
    // $json = array();
    $avatar = $usuario->buscar_avatar_usuario($id_usuario);
    echo $avatar;
}


// buscar instituciones
if ($_POST['funcion'] == 'buscar_institucion') {
    $json = array();
    $usuario->buscar_institucion();
    foreach ($usuario->objetos as $objeto) { 
        $json[] = array(
            'id_tipo_institucion' => $objeto['id_tipo_institucion'],
            'nombre_institucion' => $objeto['nombre_institucion'],
            'cod_institucion' => $objeto['cod_institucion']
        );  
    }
    
    $jsonstring = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $jsonstring;
}



//insertar usuario
if ($_POST['funcion'] == 'crear_usuario') {
    // creo la carpeta si no existe
	if(!is_dir('../uploads/avatar')){
		mkdir('../uploads/avatar', 0777, true);
        // Ruta de la carpeta de origen
        $rutaOrigen = '../assets/img/';
        // Ruta de la carpeta de destino
        $rutaDestino = '../uploads/avatar/';

        // Nombre del archivo a copiar
        $nombreArchivo = 'imgavatar.png';

        // Construir rutas completas
        $rutaArchivoOrigen = $rutaOrigen . $nombreArchivo;
        $rutaArchivoDestino = $rutaDestino . $nombreArchivo;

        // Intentar copiar el archivo
        copy($rutaArchivoOrigen, $rutaArchivoDestino);
	}
    $avatar_defecto = "imgavatar.png";
    $habilitado = 1;
    // Obtener los datos enviados post
    $nombre = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_STRING);
    $apellido = filter_input(INPUT_POST, 'apellido_usuario', FILTER_SANITIZE_STRING);
    $fechaNacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
    $ci = filter_input(INPUT_POST, 'ci', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena = filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_STRING);
    $tipo = filter_input(INPUT_POST, 'select_tipo', FILTER_VALIDATE_INT);

    // Array de errores
	$errores = array();
    // Validar los datos antes de guardarlos en la base de datos
	// Validar campo nombre
	if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
		$nombre_validado = true;
        
	}else{
		$nombre_validado = false;
		$errores['nombre'] = "El nombre no es válido";
        
	}


    if(!empty($apellido) && !is_numeric($apellido) && !preg_match("/[0-9]/", $apellido)){
		$apellido_validado = true;
        
	}else{
		$apellido_validado = false;
		$errores['apellido'] = "El apellido no es válido";
        
	}

    // Validar la cedula
	if(!empty($ci) && is_numeric($ci) && strlen($ci) == 10){
		$ci_validado = true;
	}else{
		$ci_validado = false;
		$errores['cedula'] = "La cedula no es válido";
	}

    // Validar la contraseña
	if(!empty($contrasena)){
		$password_validado = true;
	}else{
		$password_validado = false;
		$errores['password'] = "La contraseña está vacía";
	}


    // Validar apellidos
    if(count($errores) == 0){
        // Llamar al método crear del objeto usuario
        $resultado = $usuario->crear($nombre, $apellido, $fechaNacimiento, $ci, $correo, $contrasena, $tipo, $habilitado, $avatar_defecto);
        echo $resultado;
       
    }else{
	    $jsonstring = json_encode($errores);
        echo $jsonstring;
	}

    
    
}



// deshabilitar usuario
if($_POST['funcion']=='deshabilitar-usu'){
 $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
 $id_deshabilitar = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
 $usuario->deshabilitar_usuario($pass, $id_deshabilitar, $id_usuario);
}


// habilitar usuario
if($_POST['funcion']=='habilitar-usu'){
  $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
  $id_habilitar = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);;
  $usuario->habilitar_usuario($pass, $id_habilitar, $id_usuario);

}


// borrar usuario
if($_POST['funcion']=='borrar-usuario'){
 $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
 // $id_borrado=$_POST['id_usuario'];
 $id_borrado = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
 $usuario->borrar($pass, $id_borrado, $id_usuario);
//  $errores = $usuario->borrar($pass, $id_borrado, $id_usuario);
//  $jsonstring = json_encode($errores);
//  echo $jsonstring;
}

?>