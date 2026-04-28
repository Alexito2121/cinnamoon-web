<?php
include 'conexion.php';
session_start();

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_SESSION['rol'] === 'admin'){
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $sql = "DELETE FROM usuarios WHERE id = '$id'";

    if(mysqli_query($conexion, $sql)){
        header("Location: admin.php?eliminado=1");
        exit();
    }
} else {
    header("Location: admin.php");
    exit();
}
?>