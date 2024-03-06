<?php
session_name("connectmate");
// iniciar sessiones
session_start();

if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2 || $_SESSION['us_tipo'] == 3 || $_SESSION['us_tipo'] == 4) {
    include_once 'layouts/header.php';
    include_once 'layouts/nav.php';
?>


    <!-- contenido de la pagina -->
    <div class="content-wrapper" id="producto">

        <h1 class="titulo">GESTIONAR PRODUCTO
            <?php
            if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2) {
            ?>
                <button class="inline-button" id="btn-crear-producto"><i class="fas fa-plus"></i> Producto</button>
            <?php
            }
            ?>
        </h1>
        <!--buscar -->
        <div class="conbuscar">
            <div class="ds-buscar">
                <input type="text" class="form-control" id="buscar" required>
                <label class="lbl">
                    <span class="text-span"><i class="fas fa-search"></i> BUSCAR</span>
                </label>
            </div>

            <div class="combodesplegablefiltro">
                <label></i> MARCA:</label>
                <select class="select" id="marca">

                </select>
            </div>

            <div class="combodesplegablefiltro">
                <label> GAMA:</label>
                <select class="select" id="gama">

                </select>
            </div>
        </div>
        <br>
        <!-- CONTENIDO CENTRAL -->
        <div class="central" id="productos">




        </div>


    </div>

    <!-- MODAL DE CREAR USUARIO  -->
    <div id="modal-crear-producto" class="modal-formulario">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4 class="titulo-modal">CREAR PRODUCTO</h1>
                <!-- alert de crear  -->
                <div class="stylo-alerta-confirmacion" id="add" style='display:none;'>
                    <span><i class="fas fa-check"></i>Ingresado con exito</span>
                </div>
                <div class="stylo-alerta-rechazo" id="noadd" style='display:none;'>
                    <span><i class="fas fa-times m-1"></i>Producto ya Ingresado</span>
                </div>
                <!-- form para agregar producto -->
                <form id="form-crear" class="formulario">
                  
                    <div class="form">
                        <input id="cod-sap" type="text" class="form-control" required>
                        <label class="lbl">
                            <span class="text-span"><i class="fas fa-tag"></i> CÓDIGO SAP</span>
                        </label>
                    </div>


                    <div class="combodesplegable">
                        <select class="select" id="select-categoria">
                            
                            
                        </select>
                    </div>

                    <div class="stylo-alerta-rechazo" id="categoria-error" style='display:none;'>
                        <span><i class="fas fa-times m-1"></i>La categoria no es válido</span>
                    </div>


                    <div class="combodesplegable">
                        <select class="select" id="select-marca">
                           
                            
                        </select>
                    </div>

                    <div class="stylo-alerta-rechazo" id="marca-error" style='display:none;'>
                        <span><i class="fas fa-times m-1"></i>La marca no es válido</span>
                    </div>
                      

                    <div class="form">
                        <input id="nombre" type="text" class="form-control" required>
                        <label class="lbl">
                            <span class="text-span"><i class="fas fa-network-wired"></i> NOMBRE</span>
                        </label>
                    </div>
                    
                    <div class="stylo-alerta-rechazo" id="nombre-error" style='display:none;'>
                        <span><i class="fas fa-times m-1"></i>El nombre no es válido</span>
                    </div>


                    <div class="form">
                        <input id="descripcion" type="text" class="form-control" required>
                        <label class="lbl">
                            <span class="text-span"><i class="fas fa-info-circle"></i> DESCRIPCION</span>
                        </label>
                    </div>
                    

                    <div class="form">
                        <input id="precio" type="txt" class="form-control" required>
                        <label class="lbl">
                            <span class="text-span"><i class="fas fa-dollar-sign"></i> PRECIO</span>
                        </label>
                    </div>
                    <div class="stylo-alerta-rechazo" id="precio-error" style='display:none;'>
                        <span><i class="fas fa-times m-1"></i>El Precio no es válido</span>
                    </div>

                    <div class="form">
                        <input id="stock" type="number" class="form-control" required>
                        <label class="lbl">
                            <span class="text-span"><i class="fas fa-cubes"></i> STOCK</span>
                        </label>
                    </div>

                    <div class="stylo-alerta-rechazo" id="stock-error" style='display:none;'>
                        <span><i class="fas fa-times m-1"></i>El stock no es válido</span>
                    </div>

 

                    <!-- <div class="form">
                        <input id="oferte" type="text" class="form-control" required>
                        <label class="lbl">
                            <span class="text-span"><i class="fas fa-percent"></i> OFERTA</span>
                        </label>
                    </div> -->



                    <div class="combodesplegable">
                        <select class="select" id="select-regalo">
                            
                
                        </select>
                    </div>

                    <div class="stylo-alerta-rechazo" id="regalo-error" style='display:none;'>
                        <span><i class="fas fa-times m-1"></i>El regalo no es válido</span>
                    </div>


                    <div class="combodesplegable">
                        <select class="select" id="select-gama">
                            
                
                        </select>
                    </div>

                    <div class="stylo-alerta-rechazo" id="gama-error" style='display:none;'>
                        <span><i class="fas fa-times m-1"></i>La gama no es válido</span>
                    </div>

                    <br>

                    <div class="image-upload">
                        <label for="envimg" class="custom-file-upload">
                            <i class="fas fa-cloud-upload-alt"></i> Seleccionar imagen
                        </label>
                        <input type="file" name="img" id="envimg" accept="image/*">
                    </div>
                    <br>
                    <p>Tamaño máximo: 2MB. Formatos permitidos: JPG, PNG, GIF.</p>

                    <div class="stylo-alerta-rechazo" id="img-error" style='display:none;'>
                        <span><i class="fas fa-times m-1"></i>El img no es válido</span>
                    </div>

                    <div class="vista-img">
        
                    </div> 


                    <div class="button-container">
                        <!-- botones cerrar y guardar -->
                        <button type="submit" class="inline-button">Guardar</button>
                        <button type="button" class="inline-button-eliminar" id="btn-cerrar-modal">Cerrar</button>

                    </div>
                </form>
        </div>
    </div>



<?php
    include_once 'layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>
<script src="../assets/js/producto.js"></script>