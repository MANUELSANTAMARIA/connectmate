<?php
session_name("connectmate");
// iniciar sessiones
session_start();

if($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2 || $_SESSION['us_tipo'] == 3 || $_SESSION['us_tipo'] == 4 ){
    include_once 'layouts/header.php';
    include_once 'layouts/nav.php';
?>

<input id="id_usuario" type="hidden" value="<?= $_SESSION["usuario"]; ?>">
<!-- contenido de la pagina -->
<div class="content-wrapper" id="datos_personales">

</div>

 <!-- modal de cambiar avatar -->
 <div id="modal-cambiar-avatar" class="modal">
  <div class="modal-content">
  <span class="close">&times;</span>
    <h4 class="titulo-modal">CAMBIAR AVATAR</h1>
    <!-- alert de avatar -->
    <div class="stylo-alerta-confirmacion" id="edit" style='display:none;'>
      <span><i class="fas fa-check"></i>Se cambio Avatar</span>
    </div>
    <div class="stylo-alerta-rechazo" id="noedit" style='display:none;'>
      <span><i class="fas fa-times m-1"></i>Formato no soportado</span>
    </div>
    <!-- form de cambiar contraseña -->
    <form id="form-avatar" class="formulario">
      <label for="avatar">Seleccionar un nuevo avatar:</label>
      <input type="file" name="avatar" id="avatar" accept="image/*" required>
      <p>Tamaño máximo: 2MB. Formatos permitidos: JPG, PNG, GIF.</p>

      <div class="vista-previa">
        
      </div>

      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button">Guardar</button>
        <button type="button" class="inline-button-eliminar cerrar-cambiar-avatar" id="">Cerrar</button>
        
      </div>  
     </form>
    
    
  </div>
</div>
 




<?php
include_once 'layouts/footer.php';
}else{
    header('Location: ../index.php');
}
?>


<script src="../assets/js/datos_personales.js"></script>