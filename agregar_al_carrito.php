<?php
session_start();
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    // Capturamos la cantidad del parámetro GET, por defecto es 1
    $cantidad = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : 1;
    
    // Verificamos si el producto tiene stock antes de agregarlo
    $consulta = mysqli_query($conexion, "SELECT * FROM productos WHERE id = '$id'");
    $producto = mysqli_fetch_assoc($consulta);

    if ($producto && $producto['stock'] >= $cantidad) {
        // Preparamos los datos del producto
        $item = array(
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'imagen' => $producto['imagen'],
            'cantidad' => $cantidad // Guardamos la cantidad solicitada
        );

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        // Buscamos si el producto ya está en el carrito para actualizar su cantidad
        $encontrado = false;
        foreach ($_SESSION['carrito'] as $indice => $producto_carrito) {
            if ($producto_carrito['id'] == $id) {
                $_SESSION['carrito'][$indice]['cantidad'] += $cantidad;
                $encontrado = true;
                break;
            }
        }

        // Si no estaba en el carrito, lo agregamos como nuevo elemento
        if (!$encontrado) {
            $_SESSION['carrito'][] = $item;
        }
        
        header("Location: home.php?status=agregado#productos");
    } else {
        // Si no hay suficiente stock, mandamos un error
        header("Location: home.php?error=agotado#productos");
    }
} else {
    header("Location: home.php");
}
exit();
?>