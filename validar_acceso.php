<?php
include 'conexion.php';

// Recibimos el email (del campo oculto) y el código que escribió el usuario
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$codigo_user = isset($_POST['codigo_user']) ? trim($_POST['codigo_user']) : '';

// 1. Verificamos que los campos no estén vacíos
if (empty($email) || empty($codigo_user)) {
    echo "<script>alert('Por favor, ingresa el código.'); window.history.back();</script>";
    exit();
}

// 2. Buscamos en la base de datos si existe un usuario con ese email Y ese código de recuperación
$sql = "SELECT * FROM usuarios WHERE email = '$email' AND codigo_recuperacion = '$codigo_user'";
$resultado = mysqli_query($conexion, $sql);

// 3. Comprobamos si encontramos coincidencia
if (mysqli_num_rows($resultado) > 0) {
    // ¡Código correcto! 
    // Redirigimos a la página donde podrá escribir su nueva contraseña.
    // Pasamos el email por la URL (método GET) para usarlo en el siguiente paso.
    header("Location: nueva_clave.php?email=" . urlencode($email));
    exit();
} else {
    // El código no coincide o ya expiró
    echo "<script>alert('El código es incorrecto o no coincide con nuestros registros. Inténtalo de nuevo.'); window.location='olvide_clave.php';</script>";
}

mysqli_close($conexion);
?>