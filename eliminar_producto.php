<?php
session_start();
include 'conexion.php';

// PERMISOS: Admin y Empleado permitidos
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'empleado')) {
    header("Location: home.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM productos WHERE id = $id";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: home.php#productos");
        exit();
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
}
?>