<?php
include_once "conexion.php";
class dashboard
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion();
        $this->acceso = $db->pdo;
    }

    function total_productos_vendidos()
    {

        if (!empty($_POST['fecha_inicio']) && !empty($_POST['fecha_fin'])) {
            // Fechas de inicio y fin (en formato 'YYYY-MM-DD')
            $fechaInicio = $_POST['fecha_inicio'];
            $fechaFin = $_POST['fecha_fin'];
            // Incrementa la fecha de fin en un día para incluir el día de fin
            $fechaFin = date('Y-m-d', strtotime($fechaFin . ' +1 day'));
            $sql = "SELECT SUM(unidad) AS total_productos_vendidos FROM venta WHERE fecha BETWEEN :fechaInicio AND :fechaFin";
            // Preparación de la consulta SQL para su ejecución
            $query = $this->acceso->prepare($sql);
            // Ejecución de la consulta preparada
            $query->execute(array(':fechaInicio' => $fechaInicio, ':fechaFin' => $fechaFin));
            $consulta = $query->fetchColumn();
            return $consulta;

        } else {
            $sql = "SELECT SUM(unidad)AS total_productos_vendidos FROM venta";
            // Preparación de la consulta SQL para su ejecución
            $query = $this->acceso->prepare($sql);
            // Ejecución de la consulta preparada
            $query->execute();
            // Recuperación del resultado de la consulta
            $total_productos_vendidos = $query->fetchColumn();
            // Retorno de los resultados obtenidos de la consulta
            return $total_productos_vendidos;
        }
    }

    function productos_mas_vendidos()
    {
        if (!empty($_POST['fecha_inicio']) && !empty($_POST['fecha_fin'])) {
            // Fechas de inicio y fin (en formato 'YYYY-MM-DD')
            $fechaInicio = $_POST['fecha_inicio'];
            $fechaFin = $_POST['fecha_fin'];
            // Incrementa la fecha de fin en un día para incluir el día de fin
            $fechaFin = date('Y-m-d', strtotime($fechaFin . ' +1 day'));
            $sql = "SELECT venta.producto_cod, producto.nombre_producto, SUM(venta.unidad) AS total_vendido
            FROM venta 
            JOIN producto ON venta.producto_cod = producto.cod_producto
            WHERE fecha BETWEEN :fechaInicio AND :fechaFin
            GROUP BY venta.producto_cod
            ORDER BY total_vendido DESC
            LIMIT 6";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':fechaInicio' => $fechaInicio, ':fechaFin' => $fechaFin));
            // Recuperación del resultado de la consulta
            $productos_mas_vendidos = $query->fetchall();
            return $productos_mas_vendidos;
        }else{
            $sql = "SELECT venta.producto_cod, producto.nombre_producto, SUM(venta.unidad) AS total_vendido
            FROM venta 
            JOIN producto ON venta.producto_cod = producto.cod_producto
            GROUP BY venta.producto_cod
            ORDER BY total_vendido DESC
            LIMIT 6;";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            // Recuperación del resultado de la consulta
            $productos_mas_vendidos = $query->fetchall();
            return $productos_mas_vendidos;
        }
    }
}
