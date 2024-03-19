<?php
session_name("connectmate");
//iniciar sesiones
session_start();
if($_SESSION['us_tipo']==4){
    include_once 'layouts/header.php';
    include_once 'layouts/nav.php';
?>
<!-- contenido de la pagina -->
<div class="content-wrapper">
    <h1 class="titulo">HOME</h1>                     
  

 

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