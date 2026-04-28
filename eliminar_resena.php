<?php
session_start();
include 'conexion.php';

// Verificamos que sea admin, si no, lo mandamos fuera
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: acceso.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['id_p'])) {
    $id_resena = $_GET['id'];
    $id_producto = $_GET['id_p'];

    // Ejecutar la eliminación
    $query = "DELETE FROM reseñas WHERE id = $id_resena";
    
    if (mysqli_query($conexion, $query)) {
        // Regresamos a la página de reseñas del producto
        header("Location: ver_resenas.php?id=$id_producto&msg=borrado");
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
} else {
    header("Location: home.php");
}
?>