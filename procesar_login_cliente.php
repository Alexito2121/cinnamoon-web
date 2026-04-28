<?php
session_start();
include 'conexion.php';

// Limpiamos los datos de entrada
$email    = mysqli_real_escape_string($conexion, $_POST['email']    ?? '');
$password = mysqli_real_escape_string($conexion, $_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    echo "<script>alert('Por favor, completa todos los campos.'); window.location.href='login_cliente.php';</script>";
    exit();
}

// Buscamos al usuario ÚNICAMENTE en la tabla de clientes
$query = "SELECT * FROM clientes WHERE email = '$email' AND password = '$password' LIMIT 1";
$resultado = mysqli_query($conexion, $query);

if ($row = mysqli_fetch_assoc($resultado)) {
    // Si los datos coinciden, guardamos la información en la sesión
    $_SESSION['usuario'] = $row['nombre'];
    $_SESSION['id_cliente'] = $row['id'];
    $_SESSION['rol'] = 'cliente_fiel'; // Identificador para aplicar el 10% de descuento
    $_SESSION['puntos'] = $row['puntos'];

    // Redirigimos al home ya logueado
    header("Location: home.php");
    exit();
} else {
    // Si no se encuentra el registro o los datos están mal
    echo "<script>
            alert('Correo o contraseña incorrectos. Verifica tus datos o regístrate.'); 
            window.location.href='login_cliente.php';
          </script>";
}
?>