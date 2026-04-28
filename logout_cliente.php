<?php
session_start();
// Destruimos todas las variables de sesión
session_unset();
// Destruimos la sesión en el servidor
session_destroy();

// Redirigimos al acceso principal para que elija su modo de entrada
header("Location: acceso.php");
exit();
?>