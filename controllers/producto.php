<?php
include_once '../models/producto.php';
$producto = new producto();
session_name("connectmate");
session_start();
$id_usuario = $_SESSION["usuario"];


if ($_POST["funcion"] == "categoria") {
    $json = array();
    $producto->categoria();
    // Obtener el número de elementos en $producto->objetos
    $numObjetos = count($producto->objetos);
    // Utilizar un bucle for para recorrer los elementos
    for ($i = 0; $i < $numObjetos; $i++) {
        $objeto = $producto->objetos[$i];
        $json[] = array(
            'id_categoria' => $objeto->id_categoria,
            'nombre_categoria' => $objeto->nombre_categoria
        );
    }
    // Imprimir el JSON resultante
    echo json_encode($json);
}

if ($_POST['funcion'] == 'marca') {
    $json = array();
    $producto->marca();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id_marca' => $objeto->id_marca,
            'nombre_marca' => $objeto->nombre_marca
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}


if ($_POST['funcion'] == 'regalo') {
    $json = array();
    $producto->regalo();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id_regalo' => $objeto->id_regalo,
            'nombre_regalo' => $objeto->nombre_regalo
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'gama') {
    $json = array();
    $producto->gama();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id_gama' => $objeto->id_gama,
            'nombre_gama' => $objeto->nombre_gama
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}



// buscar produco
if ($_POST['funcion'] == 'buscar_producto') {
    $json = array();
    $producto->buscar();
    foreach ($producto->objetos as $objeto) {
        $json[] = array(
            'id_producto' => $objeto->id_producto,
            'nombre' => $objeto->nombre_producto,
            'descripcion' => $objeto->nombre_producto,
            'regalo_id' => $objeto->regalo_id,
            'precio' => $objeto->precio,
            'stock' => $objeto->stock,
            'imagen' => $objeto->imagen,
            'regalo' => $objeto->nombre_regalo,
            'marca' => $objeto->nombre_marca,
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}


// crear produto

if($_POST['funcion'] == "crear_producto"){
    // creo la carpeta si no existe
    if(!is_dir('../uploads/producto')){
        mkdir('../uploads/producto', 0777, true);

    }

     $cod_sap = filter_input(INPUT_POST, 'cod_sap', FILTER_SANITIZE_STRING);
     $categoria = filter_input(INPUT_POST, 'categoria', FILTER_VALIDATE_INT);
     $marca = filter_input(INPUT_POST, 'marca', FILTER_VALIDATE_INT);
     $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
     $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
     $precio = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_STRING);
     $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
     $regalo = filter_input(INPUT_POST, 'regalo', FILTER_VALIDATE_INT);
     $gama = filter_input(INPUT_POST, 'gama', FILTER_VALIDATE_INT);
     $nombre_imagen = ''; // Inicializa el nombre de la imagen

     // Array de errores
	$errores = array();

    if(!empty($cod_sap)){
        $cod_sap_validar = true;

    }else{
        $cod_sap_validar = false;
        $errores['cod_sap'] = "El codigio No es valido";
    }
    
    if(!empty($categoria) && $categoria != "CATEGORIA"){
        $categoria_validar = true;

    }else{
        $cod_sap = false;
        $errores['categoria-error'] = "El codigio No es valido";
    }


    if(!empty($marca) && $marca != "MARCA"){
        $marca_validar = true;

    }else{
        $marca_valida = false;
        $errores['marca-error'] = "La marca No es valido";
    }


    if(!empty($nombre)){
		$nombre_validado = true;
        
	}else{
		$nombre_validado = false;
		$errores['nombre-error'] = "El nombre No es válido";
        
	}


    if(!empty($precio) && preg_match("/[0-9]/", $precio)){
		$precio_validado = true;
	}else{
		$precio_validado = false;
		$errores['precio-error'] = "El precio No es válido"; 
	}


    if(!empty($stock) && preg_match("/[0-9]/", $stock)){
		$stock_validado = true;
	}else{
		$stock_validado = false;
		$errores['stock-error'] = "El stock No es válido"; 
	}

    if(!empty($regalo) && $regalo != "REGALO"){
        $regalo_validar = true;

    }else{
        $regalo_validar = false;
        $errores['regalo-error'] = "El regalo No es valido";
    }


    if(!empty($gama) && $gama != "REGALO"){
        $gama_validar = true;

    }else{
        $gama_validar = false;
        $errores['gama-error'] = "El regalo No es valido";
    }


     // Validar imagen
     if (!empty($_FILES['img']['type']) && !in_array($_FILES['img']['type'], array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'))) {
        $errores['img'] = "El formato de imagen no es válido";
    } 


    // Validar apellidos
    if(count($errores) == 0){
         // Generar nombre de archivo único y mover imagen
        $nombre_imagen = uniqid() . '-' . $_FILES['img']['name'];
        $ruta = '../uploads/producto/' . $nombre_imagen;
        move_uploaded_file($_FILES['img']['tmp_name'], $ruta);
        // Llamar al método crear del objeto usuario
        $resultado = $producto->crear($cod_sap, $categoria, $marca, $nombre, $descripcion, $precio, $stock, $regalo, $gama, $nombre_imagen);
        echo $resultado;
        // var_dump($cod_sap."-". $categoria ."-". $marca ."-". $nombre ."-". $descripcion ."-". $precio ."-". $stock ."-". $regalo ."-". $gama ."-". $nombre_imagen);
        // die();

        
       
    }else{
	    $jsonstring = json_encode($errores);
        echo $jsonstring;
	}

     


     
        

}

// subir estock
if ($_POST['funcion'] == "subir_stock") {
    // Verifica si se han recibido los datos esperados.
    if (isset($_POST['datosTabla'])) {
        // Obtén los datos de la tabla.
        $tabla = $_POST['datosTabla'];

        // Llama al método ingresarmasivostock del modelo para procesar los datos de la tabla y obtiene la respuesta.
        $respuesta = $producto->ingresarmasivostock($tabla);

        // Convierte la respuesta a formato JSON y la imprime para enviarla de vuelta al cliente.
        echo json_encode($respuesta);
    } else {
        // Si no se recibieron los datos esperados, devuelve un mensaje de error.
        echo json_encode(array(
            'descripcion' => 'No se recibieron los datos de la tabla',
            'alert' => 'error'
        ));
    }
}
