<?php
session_start();
include 'conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $pass = $_POST['password'];

    $res = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo' AND rol = 'cliente'");
    $u = mysqli_fetch_assoc($res);

    if ($u && password_verify($pass, $u['password'])) {
        $_SESSION['id_cliente'] = $u['id'];
        $_SESSION['nombre_cliente'] = $u['nombre'];
        header("Location: tienda.php"); 
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.location='login_cliente.php';</script>";
    }
}
?>