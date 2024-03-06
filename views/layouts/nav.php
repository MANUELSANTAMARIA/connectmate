<?php
$menuHome = array(
    1 => array(
        array(
         'href' => '../views/root_catalogo.php',
         'icon' => 'fas fa-home',
         'title' => 'Inicio',
         'text' => 'INICIO'
        )
    
        ),
    2 => array(
        array(
         'href' => '../views/root_catalogo.php',
         'icon' => 'fas fa-home',
         'title' => 'Home',
         'text' => 'HOME'
        )
    
        )
    );
    $menuroot = array(
        "datos_personales" => array(
            array(
                'href' => '../views/datos_personales.php',
                'icon' => 'fa-solid fa-user',
                'title' => 'Datos Personales',
                'text' => 'DATOS PERSONALES'
            ),
            array(
                'href' => '../views/admin_usuario.php',
                'icon' => 'fas fa-users',
                'title' => 'Gestión de Usuarios',
                'text' => 'GESTIONAR USUARIOS'
            )
        ),
        "mensaje_masivo" => array(
            array(
                'href' => '../views/mensajes_whatsapp.php',
                'icon' => 'fa-brands fa-whatsapp',
                'title' => 'Mensajes Whatsapp',
                'text' => 'Mensajes Whatsapp'
            ) 
        ),

        "producto" => array(
            array(
                'href' => '../views/producto.php',
                'icon' => 'fas fa-network-wired',
                'title' => 'Gestionar Producto',
                'text' => 'producto'
            ),
            array(
                'href' => '../views/ingresar_producto_masivo.php',
                'icon' => 'fas fa-check-circle',
                'title' => 'Subir Stock',
                'text' => 'Subir Stock'
            ),
           
        ),
        

    );
    

    $menuadmin = array(
        "datos_personales" => array(
            array(
                'href' => '../views/datos_personales.php',
                'icon' => 'fa-solid fa-user',
                'title' => 'Datos Personales',
                'text' => 'DATOS PERSONALES'
            ),
        ),

        "producto" => array(
            array(
                'href' => '../views/producto.php',
                'icon' => 'fas fa-network-wired',
                'title' => 'Gestionar Producto',
                'text' => 'producto'
            ),
            array(
                'href' => '../views/ingresar_producto_masivo.php',
                'icon' => 'fas fa-check-circle',
                'title' => 'Subir Stock',
                'text' => 'Subir Stock'
            ),
           
        ),
    );


    $menuvendedor = array(
        "datos_personales" => array(
            array(
                'href' => '../views/datos_personales.php',
                'icon' => 'fa-solid fa-user',
                'title' => 'Datos Personales',
                'text' => 'DATOS PERSONALES'
            ),
        ),

        "producto" => array(
            array(
                'href' => '../views/producto.php',
                'icon' => 'fas fa-network-wired',
                'title' => 'Gestionar Producto',
                'text' => 'producto'
            ),
        ),
    );


    $menuimpulsador = array(
        "datos_personales" => array(
            array(
                'href' => '../views/datos_personales.php',
                'icon' => 'fa-solid fa-user',
                'title' => 'Datos Personales',
                'text' => 'DATOS PERSONALES'
            ),
        ),

        "producto" => array(
            array(
                'href' => '../views/producto.php',
                'icon' => 'fas fa-network-wired',
                'title' => 'Gestionar Producto',
                'text' => 'producto'
            ),
        ),
    );

$menuOpciones = array(
    1 => $menuroot ,
    2 => $menuadmin,
    3 => $menuvendedor,
    4 => $menuimpulsador

);
// Obtener el tipo de usuario actual desde $_SESSION
$userType = $_SESSION['us_tipo'];

$primerArray = $menuOpciones[$userType]; 
?>


<div class="menu__side" id="menu_side">
    <div class="btn_open" id="cambiar-direccion"><i class="fa-solid fa-caret-right" id="btn_open"></i></div>
    <?php foreach($menuHome[$userType] as $option): ?>
        <a href="#" class="home">
            <div class="name__page">
                <i class="<?= $option['icon'] ?>" title="<?= $option['title']?>"></i>
                <h4><?= $option['text'] ?></h4>
            </div>
        </a>
        <?php endforeach; ?>
        <hr>
    <nav class="options__menu">
        
            <ul class="list">
                    <li class="list__item">
                        <div>
                            <div class="option">
                             <i class="fas fa-user-cog" title="Gestión Datos Personales y Usuarios"></i>
                             <h4>Gestión Datos Personales y Usuarios</h4>
                            </div>
                        </div>
                        <ul class="list__show">
                        <?php foreach($primerArray["datos_personales"] as $option): ?>
                            <li class="list__inside">
                                <a href="<?= $option['href'] ?>">
                                 <i class="<?= $option['icon'] ?>" title="<?= $option['title']?>"></i>
                                 <h4><?= $option['text'] ?></h4>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </li>
                    <?php
                    if($userType == 1){
                    ?>
                    <!-- mensajes_masivo -->
                    <li class="list__item">
                        <div>
                            <div class="option">
                             <i class="fas fa-bullseye" title="Mensajes Masivo"></i>
                             <h4>Mensaje Masivo</h4>
                            </div>
                        </div>
                        <ul class="list__show">
                        <?php foreach($primerArray["mensaje_masivo"] as $option): ?>
                            <li class="list__inside">
                                <a href="<?= $option['href'] ?>">
                                 <i class="<?= $option['icon'] ?>" title="<?= $option['title']?>"></i>
                                 <h4><?= $option['text'] ?></h4>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </li>
                    <?php
                    }
                    ?>

                    <!-- producto -->
                    <li class="list__item">
                        <div>
                            <div class="option">
                             <i class="fas fa-box" title="Mensajes Masivo"></i>
                             <h4>Producto</h4>
                            </div>
                        </div>
                        <ul class="list__show">
                        <?php foreach($primerArray["producto"] as $option): ?>
                            <li class="list__inside">
                                <a href="<?= $option['href'] ?>">
                                 <i class="<?= $option['icon'] ?>" title="<?= $option['title']?>"></i>
                                 <h4><?= $option['text'] ?></h4>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
     
    </nav>
</div>











  
  