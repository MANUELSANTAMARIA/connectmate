<?php
session_name("connectmate");
// controlo la sesion 
session_start();
if(!empty($_SESSION['us_tipo'])){
  header('Location: controllers/login.php');
}
else{
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>connectmate</title>
    <link rel="icon" href="assets/img/logo-cnt.svg.png" type="image/x-icon">
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="./assets/css/login.css" />
  </head>
  <body class="img js-fullheight" style="background-image: url(./assets/img/bg.webp)"  >
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">INICIAR SESIÓN</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-0">
              <form action="controllers/login.php" method="post" class="signin-form">
                <div class="form-group">
                  <input type="text" class="form-control" name="usuario"  placeholder="Username" required/>
                </div>
                <div class="form-group">
                  <input id="password-field" type="password" name="password" class="form-control" placeholder="Password" required/>
                </div>
                <div class="form-group">

                <!-- ESTE EL BOTON PARA INGRESO DE USUARIO -->
                  <button type="submit" class="form-control btn btn-primary submit px-3">
                    Ingresar
                  </button>
                <!-- FIN EL BOTON PARA INGRESO DE USUARIO -->

                </div>
                <div>
                </div>
              </form>
            </div>
            <!-- <img src="./assets/img/logo-cnt.jpg" alt="presidencia" class="nuevo-ecuador"> -->
          </div>
        </div>
      </div>
    </section>
</body>
</html>
<?php
}
?>