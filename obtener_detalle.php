<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Consulta al detalle de ventas usando el campo 'producto' que confirmamos antes
    $query = mysqli_query($conexion, "SELECT * FROM detalle_ventas WHERE id_venta = $id");

    if (mysqli_num_rows($query) > 0) {
        while ($r = mysqli_fetch_assoc($query)) {
            echo '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f9f9f9; font-size: 14px;">';
            echo '<span><strong>' . $r['cantidad'] . 'x</strong> ' . htmlspecialchars($r['producto']) . '</span>';
            echo '<span style="color: #d81b60; font-weight: 800;">RD$ ' . number_format($r['precio'] * $r['cantidad'], 0) . '</span>';
            echo '</div>';
        }
    } else {
        echo '<p style="text-align:center; color: #888;">No se encontraron productos para esta orden.</p>';
    }
}
?>