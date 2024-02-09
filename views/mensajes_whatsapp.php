<?php
session_name("connectmate");
//inciar sesiones 
session_start();
if($_SESSION['us_tipo']==1){
    include_once 'layouts/header.php';
    include_once 'layouts/nav.php';
?>

<div class="content-wrapper">
    <input type="hidden" id="id-us" value="<?= $_SESSION['usuario'] ?>">

    <h1 class="titulo">Mensajes Masivos de Whatsapp</h1>
    <div class="combodesplegable-content-wrapper">
      <select class="select" id="tipo-mensaje">
        <option selected>Tipo de mensaje</option>
        <option value="1">Mensajes en Whatsapp</option>
        <option value="2">Imagen en Whatsapp</option>
        <option value="3">Documento en Whatsapp</option>
      </select> 
    </div>

    
    
    <div class="formato-tabla">


    </div>

    <div class="subirdoc">
        <label for="leer-csv" class="file-label">Selecciona el archivo en formato csv</label>
        <input type="file" class="file-input" id="leer-csv">
        
    </div>

    <button class="inline-button-msj-what" id="subir">
      Enviar <i class="fa-brands fa-whatsapp"></i>
    </button>

    <div id="tabla">
      <table id="tablares">
      </table>
    </div>
  
    
    

<?php
include_once 'layouts/footer.php';
}else{
    header('Location: ../index.php');
}
?>

<script src="../assets/js/mensajes_whatsapp.js"></script>