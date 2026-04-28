<?php
session_start();
include 'conexion.php';

// 1. Verificamos que el carrito no esté vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: home.php");
    exit;
}

// 2. Preparar datos básicos
$usuario = $_SESSION['usuario'] ?? 'Invitado';
$total = 0;

foreach ($_SESSION['carrito'] as $item) {
    // Aseguramos que el precio sea numérico para la suma
    $total += (floatval($item['precio']) * intval($item['cantidad'] ?? 1));
}

// 3. INSERTAR EN LA TABLA 'ventas'
// Nota: Asegúrate de que tu tabla tenga las columnas: usuario, total, fecha, estado
$sql_venta = "INSERT INTO ventas (usuario, total, fecha, estado) 
              VALUES ('$usuario', '$total', NOW(), 'Pendiente')";

if (mysqli_query($conexion, $sql_venta)) {
    // Si la venta se insertó con éxito, obtenemos su ID
    $id_venta = mysqli_insert_id($conexion); 

    // 4. Insertar cada producto en 'detalle_ventas' y RESTAR STOCK
    foreach ($_SESSION['carrito'] as $item) {
        $id_prod = intval($item['id']);
        $nombre_prod = mysqli_real_escape_string($conexion, $item['nombre']);
        $precio_prod = floatval($item['precio']);
        $cantidad_prod = intval($item['cantidad'] ?? 1);
        
        // Insertar detalle (ajusta los nombres de columnas si son distintos en tu DB)
        $sql_detalle = "INSERT INTO detalle_ventas (id_venta, producto, precio, cantidad) 
                        VALUES ('$id_venta', '$nombre_prod', '$precio_prod', '$cantidad_prod')";
        mysqli_query($conexion, $sql_detalle);

        // RESTAR STOCK de la tabla productos
        $sql_stock = "UPDATE productos SET stock = stock - $cantidad_prod WHERE id = $id_prod";
        mysqli_query($conexion, $sql_stock);
    }

    // 5. Solo si todo salió bien, vaciamos el carrito
    unset($_SESSION['carrito']); 

    // 6. Redirección inteligente
    if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'empleado')) {
        header("Location: ver_pedidos.php?status=success");
    } else {
        header("Location: home.php?compra=exitosa");
    }
    exit();

} else {
    // Si hay un error, lo mostramos para saber qué columna está mal
    die("Error en la base de datos: " . mysqli_error($conexion));
}
?>