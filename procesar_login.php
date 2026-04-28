<?php
include 'conexion.php';
session_start();

// Limpiamos los datos para evitar inyecciones
$email    = mysqli_real_escape_string($conexion, $_POST['email']);
$password = $_POST['password'];

// Buscamos al usuario
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($resultado);

// Verificamos si existe y si la contraseña coincide con el hash
if ($usuario && password_verify($password, $usuario['password'])) {
    // LOGIN EXITOSO
    $_SESSION['nombre_usuario'] = $usuario['nombre'];
    header("Location: bienvenida.php");
    exit();
} else {
    // LOGIN FALLIDO:
    // Redirigimos al index con un parámetro de error
    header("Location: index.php?error=credenciales_invalidas");
    exit();
}

mysqli_close($conexion);
?>