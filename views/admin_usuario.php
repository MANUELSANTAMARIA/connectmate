<?php
session_name("connectmate");
//inciar sesiones 
session_start();
if($_SESSION['us_tipo']==1){
    include_once 'layouts/header.php';
    include_once 'layouts/nav.php';
?>

<!-- contenido de la pagina -->
<div class="content-wrapper">
          <h1 class="titulo">GESTIONAR USUARIO 
            <button class="inline-button" id="crear-usuario"><i class="fas fa-plus"></i> Usuario</button>
          </h1>
    <!--buscar -->
    <div class="ds-buscar">
      <input type="text" class="form-control" id="buscar" required>
      <label class="lbl">
		    <span class="text-span"><i class="fas fa-search"></i> BUSCAR</span>
      </label>
    </div>

      <div class="contenedor-card usuarios-card">

      </div>
    
</div>


 <!-- MODAL DE CREAR USUARIO  -->
 <div id="modal-crear-usuario" class="modal-formulario">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h4 class="titulo-modal">AGREGAR USUARIO</h1>
    <!-- alert de crear usuario -->
    <div class="stylo-alerta-confirmacion" id="add" style='display:none;'>
      <span><i class="fas fa-check"></i>Ingresado con exito</span>
    </div>
    <div class="stylo-alerta-rechazo" id="noadd" style='display:none;'>
      <span><i class="fas fa-times m-1"></i>Correo ya ingresado</span>
    </div>
    <!-- form para agregar usuario -->
    <form id="form-crear" class="formulario">
        <!-- formato de formulario de usuario -->
        <div class="form">
          <input id="nombre-usu" type="text" class="form-control" required>
		      <label class="lbl">
		  	  <span class="text-span"><i class="fas fa-user"></i> NOMBRES</span>
		      </label>
        </div>
        <div class="stylo-alerta-rechazo" id="nombre" style='display:none;'>
          <span><i class="fas fa-times m-1"></i>El nombre no es válido</span>
        </div>
         
        
        <div class="form">
          <input id="apellido-usu" type="text" class="form-control" required>
		      <label class="lbl">
		  	  <span class="text-span"><i class="fas fa-user"></i> APELLIDOS</span>
		      </label>
        </div>
        <div class="stylo-alerta-rechazo" id="apellido" style='display:none;'>
          <span><i class="fas fa-times m-1"></i>El Apellido no es válido</span>
        </div>

        
        <div class="form">
          <input id="fecha-nacimiento" type="Date" class="form-control" pattern="\d{2}/\d{2}/\d{4}" required>
		      <label class="lbl">
		  	  <span class="text-span"><i class="fa-sharp fa-solid fa-calendar-week"></i> FECHA DE NACIMIENTO</span>
		      </label>
        </div>


        <div class="form">
          <input id="ci" type="number" class="form-control" required>
		      <label class="lbl">
		  	  <span class="text-span"><i class="fa-solid fa-address-card"></i> C.I</span>
		      </label>
        </div>
        <div class="stylo-alerta-rechazo" id="cedula" style='display:none;'>
          <span><i class="fas fa-times m-1"></i>La c.i no es válido</span>
        </div>

        <div class="form">
          <input id="correo" type="email" class="form-control" required>
		      <label class="lbl">
          <span class="text-span"><i class="fas fa-at"></i> CORREO</span>
		      </label>
        </div> 

        <div class="form">
          <input id="contrasena" type="password" class="form-control" required>
		      <label class="lbl">
		  	  <span class="text-span"><i class="fas fa-lock"></i> CONTRASEÑA</span>
		      </label>
        </div>
        <div class="stylo-alerta-rechazo" id="password" style='display:none;'>
          <span><i class="fas fa-times m-1"></i>La contraseña no es valida</span>
        </div>

        <div class="combodesplegable">
            <select class="select" id="select-tipo">
              <option selected>Tipo De Usuario</option>
              <option value="2">Administrador</option>
              <option value="4">Administrador-Tecnico</option>
              <option value="3">Tecnico</option>
            </select> 
        </div>


        <div class="button-container">
       <!-- botones cerrar y guardar -->
          <button type="submit" class="inline-button">Guardar</button>
          <button type="button" class="inline-button-eliminar"  id="btn-cerrar-modal-agregar-usu">Cerrar</button>
        
        </div>
    </form>
  </div>
</div>



<!-- MODAL CONFIRMAR DESHABILITAR USUARI0 -->
<div id="modal-confirmar-deshabilitar-usu" class="modal">
  <div class="modal-content">
  <span class="close">&times;</span>
  <h4 class="titulo-modal">CONFIRMAR DESHABILITAR USUARIO</h1>
  <div class="stylo-alerta-confirmacion" id="confirmar-deshabilitacion" style='display:none;'>
    <span><i class="fas fa-check"></i>Usuario Deshabilitado</span>
  </div>
  <div class="stylo-alerta-rechazo" id="rechazar-deshabilitacion" style='display:none;'>
    <span><i class="fas fa-times m-1"></i>Contraseña Incorrecta</span>
  </div>
    <!-- form de cambiar contraseña -->
    <form id="form-confirmar-deshabilitacion" class="formulario">
        <!-- contraseña vieja input -->
              <div class="form">
                <input type="password" class="form-control" id="input-deshabilitar-usu" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-unlock-alt"></i> INGRESAR PASSWORD</span>
		            </label>
              </div>
              <!-- para darle id usuario -->
              <!-- para darle id usuario -->
              <input type="hidden" id="id_deshabilitar">
              <input type="hidden" id="funciondes">
      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button-eliminar">CONFIRMAR</button>
        
      </div> 
       
     </form>
  </div>
</div>

<!-- MODAL CONFIRMAR HABILITAR USUARI0 -->
<div id="modal-confirmar-habilitar-usu" class="modal">
  <div class="modal-content">
  <span class="close">&times;</span>
  <h4 class="titulo-modal">CONFIRMAR HABILITAR USUARIO</h1>
  <div class="stylo-alerta-confirmacion" id="confirmar-habilitacion" style='display:none;'>
    <span><i class="fas fa-check"></i>Usuario Habilitado</span>
  </div>
  <div class="stylo-alerta-rechazo" id="rechazar-habilitacion" style='display:none;'>
    <span><i class="fas fa-times m-1"></i>Contraseña Incorrecta</span>
  </div>
    <!-- form de cambiar contraseña -->
    <form id="form-confirmar-habilitacion" class="formulario">
        <!-- contraseña vieja input -->
              <div class="form">
                <input type="password" class="form-control" id="input-confirmar-habilitar" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-unlock-alt"></i> INGRESAR PASSWORD</span>
		            </label>
              </div>
              <!-- para darle id usuario -->
              <input type="hidden" id="id_habilitar">
              <input type="hidden" id="funcionha">
      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button-eliminar" id="hablitar-usu">CONFIRMAR</button>
        
      </div> 
       
     </form>
  </div>
</div>


<!-- MODAL CONFIRMAR ELIMINAR USUARI0 -->
<div id="modal-confirmar-eliminar" class="modal">
  <div class="modal-content">
  <span class="close">&times;</span>
  <h4 class="titulo-modal">CONFIRMAR ELIMINACION DE USUARIO</h1>
  <div class="stylo-alerta-confirmacion" id="confirmarr" style='display:none;'>
    <span><i class="fas fa-check"></i>Usuario Eliminado</span>
  </div>
  <div class="stylo-alerta-rechazo" id="rechazar" style='display:none;'>
    <span><i class="fas fa-times m-1"></i>Contraseña Incorrecta</span>
  </div>
    <!-- form de cambiar contraseña -->
    <form id="form-confirmar" class="formulario">
        <!-- contraseña vieja input -->
              <div class="form">
                <input type="password" class="form-control" id="input-confirmar-eliminacion" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-unlock-alt"></i> INGRESAR PASSWORD</span>
		            </label>
              </div>
              <!-- para darle id usuario -->
              <input type="hidden" id="id_user">
              <input type="hidden" id="funcion">
      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button-eliminar">CONFIRMAR</button>
        
      </div> 
       
     </form>
  </div>
</div>










<?php
include_once 'layouts/footer.php';
}
else{
    header('Location: ../index.php');
}
?>

<script src="../assets/js/gestionar_usuario.js"></script>