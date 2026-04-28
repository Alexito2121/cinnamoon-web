<?php
// 1. Iniciamos sesión para manejar posibles mensajes de error si los necesitas después
session_start();

// 2. Incluimos la conexión a tu base de datos Cinamoon
include 'conexion.php';

// 3. Verificamos que los datos lleguen por el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 4. Captura y Limpieza de datos (Protección básica contra Inyección SQL)
    $nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']   ?? '');
    $email    = mysqli_real_escape_string($conexion, $_POST['email']    ?? '');
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono'] ?? '');
    $password = mysqli_real_escape_string($conexion, $_POST['password'] ?? '');

    // 5. Validación de campos obligatorios
    if (empty($nombre) || empty($email) || empty($password)) {
        echo "<script>
                alert('Error: Todos los campos son obligatorios.');
                window.location.href='registro_cliente.php';
              </script>";
        exit();
    }

    // 6. Consulta para insertar en la tabla 'clientes' (La tabla que creaste para fidelidad)
    // No incluimos 'rol' porque en esta tabla todos son clientes por defecto
    $query = "INSERT INTO clientes (nombre, email, telefono, password, puntos) 
              VALUES ('$nombre', '$email', '$telefono', '$password', 0)";

    // 7. Ejecución y Redirección
    if (mysqli_query($conexion, $query)) {
        // IMPORTANTE: Aquí NO creamos $_SESSION['usuario']. 
        // Forzamos al usuario a ir al login para que el flujo sea natural.
        header("Location: login_cliente.php?registro=exito");
        exit(); 
    } else {
        // 8. Manejo de errores específicos (como correo duplicado)
        if (mysqli_errno($conexion) == 1062) {
            echo "<script>
                    alert('Este correo ya está registrado. Intenta iniciar sesión.');
                    window.location.href='login_cliente.php';
                  </script>";
        } else {
            echo "Error interno al registrar: " . mysqli_error($conexion);
        }
    }

} else {
    // Si alguien intenta entrar a este archivo directamente sin el formulario
    header("Location: registro_cliente.php");
    exit();
}
?>