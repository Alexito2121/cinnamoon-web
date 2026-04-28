<?php
include 'conexion.php';
$res = mysqli_query($conexion, "SELECT SUM(cantidad) as total FROM carrito");
$datos = mysqli_fetch_assoc($res);
echo $datos['total'] ?? 0;
?>