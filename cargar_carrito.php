<?php
include 'conexion.php';

$sql = "SELECT * FROM carrito ORDER BY id DESC";
$resultado = mysqli_query($conexion, $sql);

$productos = [];
while($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila;
}

// Retornamos los datos en formato JSON para que JavaScript los lea fácil
echo json_encode($productos);
?>