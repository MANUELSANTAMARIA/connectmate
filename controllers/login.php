<?php
include_once '../models/usuario.php';
session_name("connectmate");
//inciar sesiones 
session_start();
// traigo la variables del usuario metodo post
$email = $_POST['usuario'];
$pass = $_POST['password'];
// Crear una instancia de la clase usuario
$usuario = new usuario();


// control de accesos ver si ahi una sesion en curso
if (!empty($_SESSION["us_tipo"])) {
    switch ($_SESSION["us_tipo"]) {
        case 1:
            header('Location: ../views/root_catalogo.php');
            break;
        case 2:
            header('Location: ../views/admin_catalogo.php');
            break;
        case 3:
            header('Location: ../views/vendedor_catalogo.php');
            break;
        case 4:
            header('Location: ../views/impulsador_catalogo.php');
            break;
        case 5:
            header('Location: ../views/bodega_catalogo.php');
            break;
    }
} else {
    //paso la funcion que esta controler de login 
    $usuario = $usuario->loguearse($email, $pass); // Llamar a la función y almacenar los resultados en $usuario

    // Verifica si se obtuvo un objeto PDO
    if (!empty($usuario)) {
        // Obtiene el estado del usuario desde la base de datos
        $estado_usuario = $usuario['estado_us_id'];
        // Verificar si el usuario está Habilitado
        if ($estado_usuario == 1) {
            // Establecer las variables de sesión
            // Establecer las variables de sesión
            $_SESSION["usuario"] = $usuario['id_us'];
            $_SESSION["nombre"] = $usuario['nombre_us'];
            $_SESSION["apellido"] = $usuario['apellido_us'];
            $_SESSION["fechanacimiento"] = $usuario['edad_us'];
            $_SESSION["ci"] = $usuario['ci_us'];
            $_SESSION["email"] = $usuario['email_us'];
            $_SESSION["us_tipo"] = $usuario['tipo_us_id'];
            $_SESSION["rol"] = $usuario['nombre_tipo_us'];
            $_SESSION["nombre_institucion"] = $usuario['nombre_institucion'];
            $_SESSION['nombre_tipo_us'] = $usuario['nombre_tipo_us'];

            // Obtener fecha actual
            $fechaActual = date('Y-m-d');
            // Calcular diferencia entre fechas
            $diff = date_diff(date_create($usuario['edad_us']), date_create($fechaActual));
            // Obtener la edad
            $edad = $diff->format('%y');
            // Edad actual
            $_SESSION["edad"] = $edad;
            $_SESSION["id_estado_usuario"] = $usuario['id_estado_us'];
            $_SESSION["nombre_estado_usuario"] = $usuario['nombre_estado_us'];
            $_SESSION["avatar"] = $usuario['avatar'];

            // Redireccionar al usuario según su tipo de usuario
            switch ($_SESSION["us_tipo"]) {
                case 1:
                    header('Location: ../views/root_catalogo.php');
                    break;
                case 2:
                    header('Location: ../views/admin_catalogo.php');
                    break;
                case 3:
                    header('Location: ../views/vendedor_catalogo.php');
                    break;
                case 4:
                    header('Location: ../views/impulsador_catalogo.php');
                    break;
                case 5:
                    header('Location: ../views/bodega_catalogo.php');
                    break;
            }
        } else {
            // Usuario no está habilitado (inactivo)
            header('Location: ../index.php');
        } //fin  Usuario no está habilitado


    } else {
        // No se encontró un usuario válido en la base de datos
        header('Location: ../index.php');
    } //fin No se encontró un usuario válido en la base de datos
}
