<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $pass1 = $_POST['password'];
    $pass2 = $_POST['confirm_password'];

    // 1. Verificar si el EMAIL ya existe
    $checkEmail = "SELECT id FROM usuarios WHERE email = '$email' LIMIT 1";
    $resEmail = mysqli_query($conexion, $checkEmail);
    if (mysqli_num_rows($resEmail) > 0) {
        header("Location: registro.php?error=duplicado");
        exit();
    }

    // 2. Verificar si el TELÉFONO ya existe
    $checkTel = "SELECT id FROM usuarios WHERE telefono = '$telefono' LIMIT 1";
    $resTel = mysqli_query($conexion, $checkTel);
    if (mysqli_num_rows($resTel) > 0) {
        header("Location: registro.php?error=tel_duplicado");
        exit();
    }

    // 3. Si todo está bien, encriptar y guardar
    $hashed_password = password_hash($pass1, PASSWORD_BCRYPT);
    $sql = "INSERT INTO usuarios (nombre, email, telefono, password, rol) 
            VALUES ('$nombre', '$email', '$telefono', '$hashed_password', 'empleado')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ver_cuentas.php?status=success");
    } else {
        header("Location: registro.php?error=db");
    }
}
?>