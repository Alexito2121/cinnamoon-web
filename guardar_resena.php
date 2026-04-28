<?php
session_start();
include 'conexion.php';

// Verificamos que vengan los datos necesarios
if (isset($_GET['id_p']) && isset($_GET['estrellas']) && isset($_GET['comentario'])) {
    
    // Limpiamos los datos para evitar errores
    $id_p = intval($_GET['id_p']);
    $estrellas = intval($_GET['estrellas']);
    $comentario = mysqli_real_escape_string($conexion, $_GET['comentario']);
    
    // Usamos el nombre del usuario logueado o 'Invitado' si no hay sesión
    $usuario = $_SESSION['usuario'] ?? ($_SESSION['nombre'] ?? 'Invitado');

    // Insertamos la reseña en la base de datos
    $query = "INSERT INTO reseñas (id_producto, usuario, comentario, estrellas, fecha) 
              VALUES ('$id_p', '$usuario', '$comentario', '$estrellas', NOW())";

    if (mysqli_query($conexion, $query)) {
        // Si todo sale bien, volvemos al home con un mensaje de éxito
        header("Location: home.php?msg=gracias");
    } else {
        echo "Error al guardar la reseña: " . mysqli_error($conexion);
    }
} else {
    // Si alguien intenta entrar al archivo sin datos, lo mandamos al inicio
    header("Location: home.php");
}
?>