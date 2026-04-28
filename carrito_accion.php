<?php
session_start();
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $cantidad = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 1;
    
    // Capturamos los nuevos datos de los extras
    $extra = isset($_GET['extra']) ? $_GET['extra'] : 'Ninguno';
    $extra_precio = isset($_GET['extra_precio']) ? floatval($_GET['extra_precio']) : 0;

    $res = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
    $p = mysqli_fetch_assoc($res);

    if ($p && $p['stock'] >= $cantidad) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $encontrado = false;
        
        // Buscamos si ya existe el MISMO producto con el MISMO extra
        foreach ($_SESSION['carrito'] as $indice => $item) {
            if ($item['id'] == $id && $item['extra'] == $extra) {
                $_SESSION['carrito'][$indice]['cantidad'] += $cantidad;
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            // Calculamos el precio total (Producto + Extra)
            $precio_final = $p['precio'] + $extra_precio;

            $_SESSION['carrito'][] = [
                'id' => $p['id'],
                'nombre' => $p['nombre'],
                'precio' => $precio_final, // Precio con extra incluido
                'extra' => $extra,         // Guardamos el nombre del extra
                'extra_precio' => $extra_precio,
                'imagen' => $p['imagen'],
                'cantidad' => $cantidad
            ];
        }
        
        header("Location: home.php?status=agregado#productos");
    } else {
        header("Location: home.php?error=stock#productos");
    }
} else {
    header("Location: home.php");
}
exit();
?>