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

    // function regalo()
    // {
    //     // Definición de la consulta SQL para seleccionar todos los registros de la tabla 'categori'
    //     $sql = "SELECT * FROM regalo";

    //     // Preparación de la consulta SQL para su ejecución
    //     $query = $this->acceso->prepare($sql);

    //     // Ejecución de la consulta preparada
    //     $query->execute();

    //     // Recuperación de todos los resultados de la consulta y asignación a la variable '$this->objetos'
    //     $this->objetos = $query->fetchall();

    //     // Retorno de los resultados obtenidos de la consulta
    //     return $this->objetos;

    // }

    function smartflex()
    {
        // Definición de la consulta SQL para seleccionar todos los registros de la tabla 'categori'
        $sql = "SELECT * FROM smartflex";

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
        $sql = "SELECT producto.*, categoria.nombre_categoria, marca.nombre_marca, smartflex.cod_smartflex, smartflex.nombre_smartflex, gama.nombre_gama 
                FROM producto 
                JOIN categoria ON producto.categoria_id = categoria.id_categoria
                JOIN marca ON producto.marca_id = marca.id_marca
                JOIN smartflex ON producto.smartflex_cod = smartflex.cod_smartflex
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

    function crear($cod_sap, $categoria, $marca, $nombre, $descripcion, $precio, $stock, $smartflex, $gama, $nombre_imagen){
        // Verifica si el código del producto ya existe en la base de datos.
        $sql = "SELECT * FROM producto WHERE cod_producto = :codigo";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':codigo' => $cod_sap));
        $numFilas = $query->rowCount();
        if ($numFilas == 0) {
            $sql = "INSERT INTO producto(cod_producto, categoria_id, marca_id, nombre_producto, descripcion_producto, precio, stock, smartflex_cod, gama_id, imagen, creado_en)
            VALUES (:cod_producto, :categoria_id, :marca_id, :nombre_producto, :descripcion_producto, :precio, :stock, :cod_smartflex, :gama_id, :imagen, NOW())";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':cod_producto' => $cod_sap,
                ':categoria_id' => $categoria,
                ':marca_id' => $marca,
                ':nombre_producto' => $nombre,
                ':descripcion_producto' => $descripcion,
                ':precio' => $precio,
                ':stock' => $stock,
                ':cod_smartflex' => $smartflex,
                ':gama_id' => $gama,
                ':imagen' => $nombre_imagen

            ));
            return "add";
        }else{

            return "codigoRepetido";


        }
        
    }

    function dato_producto($cod_producto){
         // La consulta SQL con marcadores de posición
         $sql = "SELECT producto.*, categoria.nombre_categoria, marca.nombre_marca, smartflex.cod_smartflex, smartflex.nombre_smartflex, gama.nombre_gama 
         FROM producto 
         JOIN categoria ON producto.categoria_id = categoria.id_categoria
         JOIN marca ON producto.marca_id = marca.id_marca
         JOIN smartflex ON producto.smartflex_cod = smartflex.cod_smartflex
         JOIN gama ON producto.gama_id = gama.id_gama
         WHERE cod_producto = :cod_producto";
         $query = $this->acceso->prepare($sql);
         $query->execute(array(":cod_producto" => $cod_producto));
         $this->objetos=$query->fetchall();
         return $this->objetos;
    }

    function editar($cod_sap, $categoria, $marca, $nombre, $descripcion, $precio, $stock, $smartflex, $gama, $nombre_imagen){
        $sql = "SELECT imagen FROM producto WHERE cod_producto = :codigo";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':codigo' => $cod_sap));
        $this->objetos = $query->fetch();
        $nombre_img = $this->objetos->imagen;
        
        if(!empty($nombre_imagen)){
            // Se proporcionó una imagen nueva, elimina la imagen existente si existe
            if(file_exists('../uploads/producto/'.$nombre_img)){
                // Eliminar la imagen existente del servidor
                unlink('../uploads/producto/'.$nombre_img);
            }
        } else {
            // No se proporcionó una imagen nueva, mantener la imagen existente en la base de datos
            $nombre_imagen = $nombre_img;
        
       }
        $sql = "UPDATE producto 
        SET categoria_id = :categoria_id,
            marca_id = :marca_id,
            nombre_producto = :nombre_producto, 
            descripcion_producto = :descripcion_producto, 
            precio = :precio, 
            stock = :stock, 
            smartflex_cod = :cod_smartflex, 
            gama_id = :gama_id, 
            actualizado_en = NOW(),
            imagen = :imagen
        WHERE cod_producto = :cod_producto";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
                ':cod_producto' => $cod_sap,
                ':categoria_id' => $categoria,
                ':marca_id' => $marca,
                ':nombre_producto' => $nombre,
                ':descripcion_producto' => $descripcion,
                ':precio' => $precio,
                ':stock' => $stock,
                ':cod_smartflex' => $smartflex,
                ':gama_id' => $gama,
                ':imagen' => $nombre_imagen
                

            ));
        return "add";
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
            // Itera sobre cada fila en la tabla.
            foreach ($tabla as $fila) {
                $codigo = $fila[0]; // Obtiene el código de la fila.
                $nombre = $fila[1]; // Obtiene el nombre de la fila.
                $stock = $fila[2]; // Obtiene el stock de la fila.
                // Actualiza el stock del producto.

                // aqui selciono si codigo es igual a codigo de producto y al bd stock ingresado es menor al stock
                $sql = "SELECT * FROM producto WHERE cod_producto = :codigo";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(
                    ':codigo' => $codigo,
                ));
                $producto = $query->fetch(PDO::FETCH_OBJ); // Obtén el producto como un objeto
                $stock_actual = $producto->stock; // Obtener el stock actual del producto
                // Verifica si hay una venta (stock actual > stock ingresado)
                if ($stock_actual > $stock) {
                    // Calcula la diferencia entre el stock actual y el stock ingresado
                    $unidad = $stock_actual - $stock;
                    // Inserta un registro en la tabla kardex para registrar la venta
                    $sql_insert_venta = "INSERT INTO kardex(producto_cod, tipo_transaccion_id, unidad, fecha) VALUES(:codigo, :tipo_transaccion_id, :stock, NOW())";
                    $query_insert_venta = $this->acceso->prepare($sql_insert_venta);
                    $query_insert_venta->execute(array(
                        ':stock' => $unidad,
                        ':codigo' => $codigo,
                        ':tipo_transaccion_id' => 1 // Tipo de transacción para venta
                    ));
                    // Verifica si hay una compra (stock actual < stock ingresado)
                } else if($stock_actual < $stock) {
                    // Calcula la diferencia entre el stock actual y el stock ingresado
                    $unidad = $stock - $stock_actual;
                    $sql_insert_venta = "INSERT INTO kardex(producto_cod, tipo_transaccion_id, unidad, fecha) VALUES(:codigo, :tipo_transaccion_id, :stock, NOW())";
                    $query_insert_venta = $this->acceso->prepare($sql_insert_venta);
                    $query_insert_venta->execute(array(
                        ':stock' => $unidad,
                        ':codigo' => $codigo,
                        ':tipo_transaccion_id' => 2 // Tipo de transacción para venta
                    ));
                }

                $sql = "UPDATE producto SET stock = :stock, actualizado_en = NOW() WHERE cod_producto = :codigo";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(
                    ':stock' => $stock,
                    ':codigo' => $codigo
                ));

                



            }
            // Si no hay códigos inválidos, devuelve un mensaje de éxito.
            return array(
                'descripcion' => "Se ha ingresado el stock correctamente.",
                'alert' => 'exito'
            );
        }
    }


    function cotizacion(){
        // Definición de la consulta SQL para seleccionar todos los registros de la tabla 'categori'
        $sql = "SELECT * FROM cotizacion";

        // Preparación de la consulta SQL para su ejecución
        $query = $this->acceso->prepare($sql);

        // Ejecución de la consulta preparada
        $query->execute();

        // Recuperación de todos los resultados de la consulta y asignación a la variable '$this->objetos'
        $this->objetos = $query->fetchall();

        // Retorno de los resultados obtenidos de la consulta
        return $this->objetos;
    }


    function plan(){
        // Definición de la consulta SQL para seleccionar todos los registros de la tabla 'categori'
        $sql = "SELECT * FROM plan
        JOIN rol_plan ON plan.rol_plan_id = rol_plan.id_rol_plan";

        // Preparación de la consulta SQL para su ejecución
        $query = $this->acceso->prepare($sql);

        // Ejecución de la consulta preparada
        $query->execute();

        // Recuperación de todos los resultados de la consulta y asignación a la variable '$this->objetos'
        $this->objetos = $query->fetchall();

        // Retorno de los resultados obtenidos de la consulta
        return $this->objetos;

    }


    function buscar_plan($cod_plan){
         // Definición de la consulta SQL para seleccionar todos los registros de la tabla 'categori'
         $sql = "SELECT * FROM plan
         JOIN rol_plan ON plan.rol_plan_id = rol_plan.id_rol_plan
         WHERE cod_plan = :cod_plan";
 
         // Preparación de la consulta SQL para su ejecución
         $query = $this->acceso->prepare($sql);
 
         // Ejecución de la consulta preparada
         $query->execute(array(':cod_plan' => $cod_plan));
 
         // Recuperación de todos los resultados de la consulta y asignación a la variable '$this->objetos'
         $this->objetos = $query->fetchall();
 
         // Retorno de los resultados obtenidos de la consulta
         return $this->objetos;
    }
}
