<?php
session_name("connectmate");
//iniciar sesiones
session_start();
if($_SESSION['us_tipo']==1){
    include_once 'layouts/header.php';
    include_once 'layouts/nav.php';
?>
<!-- contenido de la pagina -->
<div class="content-wrapper">
    <h1 class="titulo">HOME</h1>                     
  

 
 <!-- <div class="descargardoc">
      <h1 class="titulodes">MANUAL DE USUARIO</h1>
      <a href="../descargas/Manual_Tecnico .pdf" download="Manual_de_uso_tecnico.pdf" target="_blank" class="download-link">
        <i class="fas fa-download"></i>
      </a>
 </div> -->
 </div>

<?php
include_once 'layouts/footer.php';
?>
<?php
}
else{
    header('Location: ../index.php');
}
?>