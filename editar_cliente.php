<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$res = mysqli_query($conexion, "SELECT * FROM clientes WHERE id = $id");
$c = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $puntos = intval($_POST['puntos']);

    $update = "UPDATE clientes SET nombre='$nombre', telefono='$telefono', puntos=$puntos WHERE id=$id";
    if (mysqli_query($conexion, $update)) {
        header("Location: ver_clientes.php?msg=editado");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente | Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;800&display=swap" rel="stylesheet">
    <style>
        :root { --sky: #D0E3FF; --espresso: #4C2B08; --caramel: #BF7E46; --milky: #FFF9F0; }
        body { background: var(--sky); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: var(--milky); padding: 30px; border-radius: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h3 { color: var(--espresso); margin-top: 0; text-align: center; }
        label { display: block; font-size: 12px; font-weight: 800; color: var(--caramel); margin: 15px 0 5px 5px; text-transform: uppercase; }
        input { width: 100%; padding: 12px; border: 2px solid var(--sky); border-radius: 15px; box-sizing: border-box; font-family: inherit; font-weight: 600; }
        .btn-save { background: var(--espresso); color: white; border: none; width: 100%; padding: 15px; border-radius: 15px; font-weight: 800; cursor: pointer; margin-top: 20px; transition: 0.3s; }
        .btn-save:hover { background: var(--caramel); }
        .btn-cancel { display: block; text-align: center; color: #aaa; text-decoration: none; font-size: 13px; margin-top: 15px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Editar Cliente #<?php echo $id; ?></h3>
        <form method="POST">
            <label>Nombre Completo</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($c['nombre']); ?>" required>
            
            <label>Teléfono (WhatsApp)</label>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($c['telefono']); ?>" required>
            
            <label>Puntos de Lealtad</label>
            <input type="number" name="puntos" value="<?php echo $c['puntos']; ?>" required>
            
            <button type="submit" class="btn-save">GUARDAR CAMBIOS</button>
            <a href="ver_clientes.php" class="btn-cancel">Cancelar</a>
        </form>
    </div>
</body>
</html>