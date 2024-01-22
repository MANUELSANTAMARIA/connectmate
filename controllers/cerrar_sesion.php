<?php
session_name("connectmate");
//inciar sesiones 
session_start();
//para destruir session
session_destroy();
header("location: ../index.php");

?>