<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    exit("No autorizado");
}

if (isset($_GET['id'])) {
    $id_pedido = intval($_GET['id']);

    // 1. Obtener datos del pedido
    $res_p = mysqli_query($conexion, "SELECT cliente_nombre, precio FROM pedidos WHERE id = $id_pedido");
    $pedido = mysqli_fetch_assoc($res_p);

    if ($pedido) {
        $nombre = $pedido['cliente_nombre'];
        $precio = $pedido['precio'];
        
        // Calcular puntos (1 punto por cada 100)
        $puntos = floor($precio / 100);

        // 2. Actualizar estado del pedido
        mysqli_query($conexion, "UPDATE pedidos SET estado = 'Despachado' WHERE id = $id_pedido");

        // 3. Sumar puntos al cliente (Solo si no es "Cliente Invitado" y existe un nombre)
        if ($nombre && $nombre != 'Cliente Invitado' && $nombre != 'NULL') {
            // Buscamos al cliente por su nombre en la tabla clientes
            // IMPORTANTE: Asegúrate de que la columna en la tabla 'clientes' se llame 'nombre'
            $sql_puntos = "UPDATE clientes SET puntos = puntos + $puntos WHERE nombre = '$nombre'";
            mysqli_query($conexion, $sql_puntos);
        }

        header("Location: ver_pedidos.php?msg=exito&pts=$puntos");
        exit();
    }
}
header("Location: ver_pedidos.php");
?>