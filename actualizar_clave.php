<?php
include 'conexion.php';
session_start();

if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_SESSION['codigo_validado'])) {
    
    $pass1 = $_POST['password'];
    $pass2 = $_POST['confirm_password'];

    if ($pass1 !== $pass2) {
        header("Location: nueva_clave.php?error=1");
        exit();
    }

    $id = $_SESSION['id_recuperacion'];
    $encriptada = password_hash($pass1, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET password = '$encriptada' WHERE id = '$id'";

    if (mysqli_query($conexion, $sql)) {
        session_unset();
        session_destroy();
        header("Location: index.php?registro=exitoso"); 
        exit();
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
} else {
    header("Location: index.php");
    exit();
}
mysqli_close($conexion);
?>