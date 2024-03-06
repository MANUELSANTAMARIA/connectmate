<?php
session_name("connectmate");

// iniciar sessiones
session_start();


if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2) {
    include_once 'layouts/header.php';
    include_once 'layouts/nav.php';
?>


    <div class="content-wrapper">

        <h1 class="titulo">SUBIR STOCK</h1>
        <div class="subirstock">
            <label for="leer-csv" class="file-label">Selecciona el archivo en formato csv</label>
            <input type="file" class="file-input" id="leer-csv" accept=".csv">

        </div>
        <button class="inline-button-csv-enviar" id="subir">
            Subir <i class="fas fa-cubes"></i>
        </button>
        <div id="tabla">
            <table id="tablares">
            </table>
        </div>
    </div>



<?php
    include_once 'layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>

<script src="../assets/js/ingresar_masivo_stock.js"></script>