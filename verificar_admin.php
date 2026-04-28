<?php
session_start();

// Esta es tu clave secreta. ¡Cámbiala si quieres!
$llave_maestra = "LaDulce2026"; 
$error = false;

if (isset($_POST['master_key'])) {
    if ($_POST['master_key'] === $llave_maestra) {
        // Si la clave es correcta, damos permiso de Admin y abrimos la bóveda
        $_SESSION['rol'] = 'admin'; 
        $_SESSION['boveda_abierta'] = true; 
        header("Location: admin.php");
        exit();
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguridad - La Dulce Migaja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body { background: #fdf2f5; font-family: 'Poppins', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .lock-card { background: white; padding: 40px; border-radius: 30px; box-shadow: 0 15px 35px rgba(216, 27, 96, 0.1); text-align: center; width: 350px; border: 2px solid #d81b60; }
        h2 { font-family: 'Pacifico'; color: #d81b60; margin: 0; }
        input { width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 12px; margin: 20px 0; box-sizing: border-box; font-size: 18px; text-align: center; outline: none; }
        input:focus { border-color: #d81b60; }
        button { background: #d81b60; color: white; border: none; padding: 15px; border-radius: 12px; font-weight: 600; cursor: pointer; width: 100%; transition: 0.3s; }
        button:hover { background: #ad1457; transform: translateY(-2px); }
        .error { color: #ff5252; font-size: 13px; margin-bottom: 15px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="lock-card">
        <h2>🔒 Seguridad</h2>
        <p style="font-size: 14px; color: #5d4037;">Introduce la <b>Llave Maestra</b> para gestionar las cuentas.</p>
        
        <form method="POST">
            <input type="password" name="master_key" placeholder="Contraseña Maestra" autofocus required>
            <?php if($error): ?><div class="error">❌ Llave incorrecta</div><?php endif; ?>
            <button type="submit">Desbloquear Centro de Cuentas</button>
        </form>
        <br>
        <a href="index.php" style="color: #999; text-decoration: none; font-size: 12px;">← Volver al Inicio</a>
    </div>
</body>
</html>