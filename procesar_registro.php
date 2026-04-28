<?php
include 'conexion.php';

// Recibimos los datos del formulario
$nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']);
$email    = mysqli_real_escape_string($conexion, $_POST['email']);
$telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
$password = $_POST['password'];

// Encriptamos la clave (Seguridad profesional)
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertamos incluyendo el nuevo campo de teléfono
$sql = "INSERT INTO usuarios (nombre, email, telefono, password) 
        VALUES ('$nombre', '$email', '$telefono', '$password_hash')";

if (mysqli_query($conexion, $sql)) {
    // Redirigimos al login con un mensaje de éxito en la URL
    header("Location: index.php?registro=exitoso");
    exit();
} else {
    echo "Error al registrar: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>