<?php
include_once '../models/dashboard.php';
$dashboard = new dashboard();
session_name("connectmate");
session_start();
$id_usuario = $_SESSION["usuario"];

if($_POST["funcion"] == "total_productos_vendidos"){
    $total_productos_vendidos = $dashboard->total_productos_vendidos();
    echo $total_productos_vendidos;

}


if ($_POST["funcion"] == "productos_mas_vendidos") {
    $json = array();
    
    // Obtener los resultados de la función productos_mas_vendidos()
    $resultados = $dashboard->productos_mas_vendidos();

    // Iterar sobre los resultados y construir el array JSON
    foreach ($resultados as $objeto) {
        $json[] = array(
            'producto_cod' => $objeto->producto_cod,
            'nombre_producto' => $objeto->nombre_producto,
            'total_vendido' => $objeto->total_vendido
        );
    }

    // Convertir el array $json a formato JSON y enviarlo como respuesta
    echo json_encode($json);
}
