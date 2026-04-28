<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $stock_limite = $_POST['stock_limite'];

    // 1. Manejo del Archivo
    $nombre_foto = $_FILES['imagen_archivo']['name'];
    $ruta_temporal = $_FILES['imagen_archivo']['tmp_name'];
    
    // Creamos una ruta única para evitar que fotos con el mismo nombre se borren
    $carpeta = "imagen/";
    $ruta_final = $carpeta . time() . "_" . $nombre_foto; 

    // 2. Mover el archivo a la carpeta 'img'
    if (move_uploaded_file($ruta_temporal, $ruta_final)) {
        // 3. Guardar en la base de datos (la ruta final)
        $sql = "INSERT INTO productos (nombre, precio, imagen, stock, stock_limite) 
                VALUES ('$nombre', '$precio', '$ruta_final', '$stock', '$stock_limite')";
        
        if (mysqli_query($conexion, $sql)) {
            header("Location: ver_inventario.php?save=success");
        } else {
            echo "Error en BD: " . mysqli_error($conexion);
        }
    } else {
        echo "Error: No se pudo subir la imagen. Revisa que la carpeta 'img' exista.";
    }
}
?>