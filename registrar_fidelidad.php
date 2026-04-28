<?php
session_start();
include 'conexion.php';

// Limpiamos los datos para evitar errores
$nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']   ?? '');
$email    = mysqli_real_escape_string($conexion, $_POST['email']    ?? '');
$telefono = mysqli_real_escape_string($conexion, $_POST['telefono'] ?? '');
$password = mysqli_real_escape_string($conexion, $_POST['password'] ?? '');

if (empty($nombre) || empty($email) || empty($password)) {
    header("Location: registro.php?error=vacio");
    exit();
}

// Insertamos en la tabla usuarios (ajustado a tu DB)
$query = "INSERT INTO usuarios (nombre, email, telefono, password, rol) 
          VALUES ('$nombre', '$email', '$telefono', '$password', 'cliente')";

if (mysqli_query($conexion, $query)) {
    // Éxito: Guardamos sesión y vamos al home
    $_SESSION['usuario'] = $nombre;
    $_SESSION['rol'] = 'cliente';
    header("Location: home.php");
    exit();
} else {
    // Error de correo duplicado
    if (mysqli_errno($conexion) == 1062) {
        echo "<script>alert('Este correo ya está registrado.'); window.location.href='registro.php';</script>";
    } else {
        echo "Error en el sistema: " . mysqli_error($conexion);
    }
}
?>