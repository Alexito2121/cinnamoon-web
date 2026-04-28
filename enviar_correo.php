<?php
include 'conexion.php';
session_start();

if (isset($_POST['telefono'])) {
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);

    // Buscamos al usuario por su número de teléfono
    $sql = "SELECT id FROM usuarios WHERE telefono = '$telefono'";
    $resultado = mysqli_query($conexion, $sql);
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario) {
        // GENERAMOS CÓDIGO ALEATORIO (6 dígitos)
        $codigo_secreto = rand(100000, 999999);
        
        // Guardamos en la sesión para los siguientes pasos
        $_SESSION['id_recuperacion'] = $usuario['id'];
        $_SESSION['codigo_verificacion'] = $codigo_secreto;
        
        // Vamos a la pantalla de verificación
        header("Location: verificar_codigo.php");
        exit();
    } else {
        // Si el número no existe en la base de datos
        header("Location: olvide_clave.php?error=no_existe");
        exit();
    }
}
?>