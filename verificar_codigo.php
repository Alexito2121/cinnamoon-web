<?php
session_start();
if (!isset($_SESSION['codigo_verificacion'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código - La Dulce Migaja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .codigo-box { background: #fff5f8; border: 2px dashed #d81b60; color: #d81b60; font-size: 28px; font-weight: bold; padding: 15px; border-radius: 15px; letter-spacing: 5px; margin: 20px 0; display: inline-block; width: 90%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 style="font-family: 'Pacifico', cursive; color: #d81b60;">Verificación 🛡️</h1>
            <p style="font-size: 13px; color: #777;">Tu código de seguridad es:</p>
            
            <div class="codigo-box"><?php echo $_SESSION['codigo_verificacion']; ?></div>

            <form action="confirmar_codigo.php" method="POST" autocomplete="off">
                <div class="input-group">
                    <label>Ingresa el código</label>
                    <input type="text" name="codigo_usuario" placeholder="000000" maxlength="6" required autocomplete="off" 
                           style="text-align: center; letter-spacing: 5px; font-size: 22px; font-weight: bold;">
                </div>
                <button type="submit" class="btn">Validar Código</button>
            </form>
        </div>
    </div>
</body>
</html>