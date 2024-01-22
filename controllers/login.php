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
if (!empty($_SESSION["us_tipo"])){
    switch ($_SESSION["us_tipo"]) {
        case 1:
            header('Location: ../views/root_catalogo.php');
            break;
        case 2:
            header('Location: ../views/admin_catalogo.php');
            break;
        case 3:
            header('Location: ../views/tecnico_catalogo.php');
            break;
        case 4:
            header('Location: ../views/admin_tecnico_catalogo.php');
            break;
    }

}
else{
    //paso la funcion que esta controler de login 
    $usuario->loguearse($email, $pass);
    
    // Verifica si se obtuvo un objeto PDO
    if (!empty($usuario->objetos)) {
            // Obtiene el estado del usuario desde la base de datos
            $estado_usuario = $usuario->objetos->estado_us_id;
            // Verificar si el usuario está Habilitado
            if ($estado_usuario == 1) {
                // Establecer las variables de sesión
                $_SESSION["usuario"] = $usuario->objetos->id_us;
                $_SESSION["nombre"] = $usuario->objetos->nombre_us;
                $_SESSION["apellido"] = $usuario->objetos->apellido_us;
                $_SESSION["fechanacimiento"] = $usuario->objetos->edad_us;
                $_SESSION["ci"] = $usuario->objetos->ci_us;
                $_SESSION["email"] = $usuario->objetos->email_us;
                $_SESSION["us_tipo"] = $usuario->objetos->tipo_us_id;
                $_SESSION["rol"] = $usuario->objetos->nombre_tipo_us;
                $_SESSION["nombre_institucion"] = $usuario->objetos->nombre_institucion;
                $_SESSION['nombre_tipo_us'] = $usuario->objetos->nombre_tipo_us;
    
                // Obtener fecha actual
                $fechaActual = date('Y-m-d');
                // Calcular diferencia entre fechas
                $diff = date_diff(date_create($usuario->objetos->edad_us), date_create($fechaActual));
                // Obtener la edad
                $edad = $diff->format('%y');
                // Edad actual
                $_SESSION["edad"] = $edad;
                $_SESSION["id_estado_usuario"] = $usuario->objetos->id_estado_us;
                $_SESSION["nombre_estado_usuario"] = $usuario->objetos->nombre_estado_us;
                $_SESSION["avatar"] = $usuario->objetos->avatar;
    
                // Redireccionar al usuario según su tipo de usuario
                switch ($_SESSION["us_tipo"]) {
                    case 1:
                        header('Location:../views/root_catalogo.php');
                        break;
                    case 2:
                        header('Location:../views/admin_catalogo.php');
                        break;
                    case 3:
                        header('Location:../views/tecnico_catalogo.php');
                        break;
                    case 4:
                        header('Location:../views/admin_tecnico_catalogo.php');
                        break;
                }
            } else {
                // Usuario no está habilitado (inactivo)
                header('Location: ../index.php');
            }//fin  Usuario no está habilitado
        
       
    } else {
        // No se encontró un usuario válido en la base de datos
        header('Location: ../index.php');
       
    }//fin No se encontró un usuario válido en la base de datos
}