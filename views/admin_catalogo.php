<?php
session_name("connectmate");
//iniciar sesiones
session_start();
if ($_SESSION['us_tipo'] == 2) {
    include_once 'layouts/header.php';
    include_once 'layouts/nav.php';
?>
    <!-- contenido de la pagina -->
    <!-- contenido de la pagina -->
    <div class="content-wrapper">

        <h1 class="titulo">HOME</h1>

        
        <input type="text" class="fecha" id="fecha-inicio" placeholder="Seleccione Una fecha Inicio">
        <input type="text" class="fecha" id="fecha-fin" placeholder="Seleccione Una fecha Fin">


        <div class="kpi">
            <div class="contenedor-card">
                <div class="subcard">
                    <h5>TOTAL DE PRODUCTO VENDIDOS</h5>
                    <p id="total_productos_vendidos"></p>
                </div>
            
            </div>
        </div>
        <div class="subcard-inf">
            <h5>PRODUCTOS MAS VENDIDOS</h5>
            <canvas id="miGrafico">

            </canvas>

        </div>
    </div>

    <?php
    include_once 'layouts/footer.php';
    ?>
<?php
} else {
    header('Location: ../index.php');
}


?>
<script src="../assets/js/dashboard.js"></script>


