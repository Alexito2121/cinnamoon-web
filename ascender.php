<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $sql = "UPDATE usuarios SET rol = 'admin' WHERE id = '$id'";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: admin.php?update=success");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>