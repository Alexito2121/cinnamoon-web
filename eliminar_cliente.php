<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM clientes WHERE id = $id";
    
    if (mysqli_query($conexion, $query)) {
        header("Location: ver_clientes.php?msg=eliminado");
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
} else {
    header("Location: ver_clientes.php");
}
?>