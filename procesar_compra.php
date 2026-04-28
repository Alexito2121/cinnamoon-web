<?php
session_start();
include 'conexion.php';

if (!empty($_SESSION['carrito'])) {
    $total = $_POST['total_pago'];
    $nombres = array_column($_SESSION['carrito'], 'nombre');
    $productos_texto = mysqli_real_escape_string($conexion, implode(", ", $nombres));
    $cliente = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "Cliente Web";

    // Guardar en la tabla que creamos en SQL
    $sql = "INSERT INTO pedidos (cliente_nombre, productos, total, fecha) 
            VALUES ('$cliente', '$productos_texto', '$total', NOW())";

    if (mysqli_query($conexion, $sql)) {
        unset($_SESSION['carrito']); 
        header("Location: home.php?compra=1"); // Parámetro para la alerta de éxito
        exit();
    }
} else {
    header("Location: home.php");
}
?>