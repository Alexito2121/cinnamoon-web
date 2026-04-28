<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Acceso - La Dulce Migaja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 style="font-family: 'Pacifico', cursive; color: #d81b60; margin-bottom: 10px;">Seguridad 📱</h1>
            <p style="font-size: 14px; color: #777; margin-bottom: 25px;">Ingresa tu número registrado sin sugerencias de guardado.</p>

            <?php if(isset($_GET['error']) && $_GET['error'] == 'no_existe'): ?>
                <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; border: 1px solid #ef9a9a; text-align: center;">
                    ❌ Este número no está en nuestra cocina.
                </div>
            <?php endif; ?>

            <form action="enviar_correo.php" method="POST" autocomplete="off">
                <div class="input-group">
                    <label>Teléfono Móvil</label>
                    <input type="text" name="telefono" placeholder="Ej: 8091234567" required autocomplete="off">
                </div>
                
                <button type="submit" class="btn">Verificar Número</button>
                
                <p class="switch-text" style="margin-top: 25px;">
                    <a href="index.php" style="color: #999; text-decoration: none; font-size: 13px;">← Volver al inicio</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>