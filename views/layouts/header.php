<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connectmate</title>

<link rel="stylesheet" href="../assets/css/nav.css">


<!-- DATATABLE css-->
<link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/sl-1.6.2/datatables.min.css" rel="stylesheet"/>
<!-- resposible -->
<link type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" rel="stylesheet"/> 

<!-- fontawesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/> 
<!-- link css -->
<link rel="stylesheet" href="../assets/css/contenido.css">
 

</head>
<body id="body">
    <header>
    <p>
        <?= strtoupper($_SESSION['nombre_tipo_us']); ?>
      </p>
        <div class="menu__ajustes">
        
            <img src="../assets/img/logo-cnt.svg" alt="">
            <i class="fa-regular fa-user"></i>
            <?= "Bienvenido"." ". $_SESSION["nombre"] . " " . $_SESSION["apellido"]; ?></p>
            
            <i class="fa-solid fa-caret-down open-menu-ajustes"></i>
            <div class="dropdown-content" id="dropdown-menu">
                <button class="inline-button cambiar-contrasena">Cambiar Contraseña</button>
                <a href="../controllers/cerrar_sesion.php">Cerrar Sesión</a>
                
            </div>
        </div>
    </header>



<!-- modal de cambiar contraseña -->
<div id="modal-cambiar-contraseña" class="modal">
  <div class="modal-content">
  <span class="close">&times;</span>
    <h4 class="titulo-modal">CAMBIAR CONTRASEÑA</h1>
    <!-- alert de crear usuario -->
    <div class="stylo-alerta-confirmacion" id="update" style='display:none;'>
      <span><i class="fas fa-check"></i>Cambio de Contraseña</span>
    </div>
    <div class="stylo-alerta-rechazo" id="noupdate" style='display:none;'>
      <span><i class="fas fa-times m-1"></i>Contraseña Incorrecta</span>
    </div>
    <!-- form de cambiar contraseña -->
    <form id="form-pass" class="formulario">
        
        <!-- contraseña vieja input -->
              <div class="form">
                <input id="oldpass" type="password" class="form-control" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-unlock-alt"></i> INGRESAR CONTRASEÑA</span>
		            </label>
              </div>

              <div class="form">
                <input id="newpass" type="password" class="form-control" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-lock"></i> INGRESAR CONTRASEÑA NUEVA</span>
		            </label>
              </div>
      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button">Guardar</button>
        <button type="button" class="inline-button-eliminar" id="btn-cerrar-modal-cambir-pass">Cerrar</button>
        
      </div>  
     </form>
    
    
  </div>
</div>

