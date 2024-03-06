<?php
include_once 'conexion.php';
class producto
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion();
        $this->acceso = $db->pdo;
    }

    function categoria()
    {
        // Definición de la consulta SQL para seleccionar todos los registros de la tabla 'categori'
        $sql = "SELECT * FROM categoria";

        // Preparación de la consulta SQL para su ejecución
        $query = $this->acceso->prepare($sql);

        // Ejecución de la consulta preparada
        $query->execute();

        // Recuperación de todos los resultados de la consulta y asignación a la variable '$this->objetos'
        $this->objetos = $query->fetchall();

        // Retorno de los resultados obtenidos de la consulta
        return $this->objetos;
    }

    function marca()
    {
        $sql = "SELECT * FROM marca";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function regalo()
    {
        // Definición de la consulta SQL para seleccionar todos los registros de la tabla 'categori'
        $sql = "SELECT * FROM regalo";

        // Preparación de la consulta SQL para su ejecución
        $query = $this->acceso->prepare($sql);

        // Ejecución de la consulta preparada
        $query->execute();

        // Recuperación de todos los resultados de la consulta y asignación a la variable '$this->objetos'
        $this->objetos = $query->fetchall();

        // Retorno de los resultados obtenidos de la consulta
        return $this->objetos;

    }

    function gama()
    {
        $sql = "SELECT * FROM gama";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function buscar()
    {
        // Inicializar las variables
        $marca = isset($_POST['marca']) ? $_POST['marca'] : "";
        $consulta = isset($_POST['consulta']) ? $_POST['consulta'] : "";
        $gama = isset($_POST['gama']) ? $_POST['gama'] : "";

        // La consulta SQL con marcadores de posición
        $sql = "SELECT producto.*, categoria.nombre_categoria, marca.nombre_marca, regalo.nombre_regalo, gama.nombre_gama 
                FROM producto 
                JOIN categoria ON producto.categoria_id = categoria.id_categoria
                JOIN marca ON producto.marca_id = marca.id_marca
                JOIN regalo ON producto.regalo_id = regalo.id_regalo
                JOIN gama ON producto.gama_id = gama.id_gama";

        // Array para almacenar las condiciones de la consulta
        $conditions = [];
        $params = [];

        if (!empty($consulta)) {
            $conditions[] = "nombre_producto LIKE :consulta";
            $params[':consulta'] = "%$consulta%";
        }

        if ($marca !== "" && $marca !== "MARCA") {
            $conditions[] = "marca_id = :marca";
            $params[':marca'] = $marca;
        }

        if ($gama !== "" && $gama !== "GAMA") {
            $conditions[] = "gama_id = :gama";
            $params[':gama'] = $gama;
        }

        // Si hay condiciones, agregamos la cláusula WHERE
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY id_producto LIMIT 50";

        // Preparar la consulta
        $query = $this->acceso->prepare($sql);

        // Ejecutar la consulta con los valores de los parámetros
        $query->execute($params);

        // Obtener los resultados
        $this->objetos = $query->fetchAll();

        // Retornar los resultados
        return $this->objetos;
    }

    function crear($cod_sap, $categoria, $marca, $nombre, $descripcion, $precio, $stock, $regalo, $gama, $nombre_imagen){
        // Verifica si el código del producto ya existe en la base de datos.
        $sql = "SELECT * FROM producto WHERE cod_producto = :codigo";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':codigo' => $cod_sap));
        $numFilas = $query->rowCount();
        if ($numFilas == 0) {
            $sql = "INSERT INTO producto(cod_producto, categoria_id, marca_id, nombre_producto, descripcion_producto, precio, stock, regalo_id, gama_id, imagen, creado_en)
            VALUES (:cod_producto, :categoria_id, :marca_id, :nombre_producto, :descripcion_producto, :precio, :stock, :regalo_id, :gama_id, :imagen, NOW())";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':cod_producto' => $cod_sap,
                ':categoria_id' => $categoria,
                ':marca_id' => $marca,
                ':nombre_producto' => $nombre,
                ':descripcion_producto' => $descripcion,
                ':precio' => $precio,
                ':stock' => $stock,
                ':regalo_id' => $regalo,
                ':gama_id' => $gama,
                ':imagen' => $nombre_imagen

            ));
            return "add";
        }else{

            return "codigoRepetido";


        }
        
    }

    function ingresarmasivostock($tabla)
    {
        // Inicializa un array para almacenar los datos de códigos inválidos.
        $cod_invalido = array();

        // Itera sobre cada fila en la tabla.
        foreach ($tabla as $fila) {
            // Verifica si la fila es un array y tiene una longitud mayor a 0.
            if (is_array($fila) && count($fila) > 0) {
                $codigo = $fila[0]; // Obtiene el código de la fila.
                $nombre = $fila[1]; // Obtiene el nombre de la fila.
                $stock = $fila[2]; // Obtiene el stock de la fila.

                // Verifica si el código del producto ya existe en la base de datos.
                $sql = "SELECT * FROM producto WHERE cod_producto = :codigo";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':codigo' => $codigo));
                $numFilas = $query->rowCount();

                if ($numFilas == 0) {
                    // Almacena los datos de la fila en el array de códigos inválidos.
                    $cod_invalido[] = array(
                        'codigo' => $codigo,
                        'nombre' => $nombre,
                        'stock' => $stock
                    );
                } else {
                    // Actualiza el stock del producto.
                    $sql = "UPDATE producto SET stock = :stock, actualizado_en = NOW() WHERE cod_producto = :codigo";
                    $query = $this->acceso->prepare($sql);
                    $query->execute(array(
                        ':stock' => $stock,
                        ':codigo' => $codigo
                    ));
                }
            } else {
                // Si la fila no tiene una longitud mayor 3
                return array(
                    'descripcion' => 'La tabla no es válida',
                    'alert' => 'error'
                );
            }
        }

        if (!empty($cod_invalido)) {
            // Si hay códigos inválidos, devuelve la lista de ellos.
            return array(
                'descripcion' => $cod_invalido,
                'alert' => 'error-codigo'
            );
        } else {
            // Si no hay códigos inválidos, devuelve un mensaje de éxito.
            return array(
                'descripcion' => "Se ha ingresado el stock correctamente.",
                'alert' => 'exito'
            );
        }
    }
}
