<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password_ingresada = $_POST['password']; 

    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $datos = mysqli_fetch_assoc($resultado);
        
        // Comparamos la clave escrita con la encriptada de la BD
        if (password_verify($password_ingresada, $datos['password'])) {
            $_SESSION['usuario_id'] = $datos['id'];
            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['rol'] = $datos['rol'];

            header("Location: home.php");
            exit();
        } else {
            header("Location: index.php?error=datos_invalidos");
            exit();
        }
    } else {
        header("Location: index.php?error=datos_invalidos");
        exit();
    }
}
?>