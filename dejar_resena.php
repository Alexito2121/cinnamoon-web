<?php
session_start();
include 'conexion.php';

$id_p = $_GET['id'];
$user_actual = $_SESSION['usuario'] ?? 'Invitado';

if ($_POST) {
    $estrellas = $_POST['estrellas'];
    $comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);
    
    mysqli_query($conexion, "INSERT INTO reseñas (id_producto, usuario, estrellas, comentario) 
                            VALUES ('$id_p', '$user_actual', '$estrellas', '$comentario')");
    
    header("Location: home.php#productos");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reseñar Producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fdf2f5; display: flex; justify-content: center; padding: 50px; }
        .box { background: white; padding: 30px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        select, textarea { width: 100%; padding: 12px; margin: 10px 0; border-radius: 10px; border: 1px solid #ddd; }
        .btn { background: #d81b60; color: white; border: none; padding: 12px 25px; border-radius: 20px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="color: #d81b60; font-family: 'Pacifico';">Tu opinión cuenta</h2>
        <form method="POST">
            <label>Calificación:</label>
            <select name="estrellas">
                <option value="5">⭐⭐⭐⭐⭐ (Excelente)</option>
                <option value="4">⭐⭐⭐⭐ (Muy bueno)</option>
                <option value="3">⭐⭐⭐ (Regular)</option>
                <option value="2">⭐⭐ (Malo)</option>
                <option value="1">⭐ (Pésimo)</option>
            </select>
            <textarea name="comentario" placeholder="¿Qué te pareció este postre?" rows="4" required></textarea>
            <button type="submit" class="btn">PUBLICAR MI RESEÑA</button>
        </form>
    </div>
</body>
</html>