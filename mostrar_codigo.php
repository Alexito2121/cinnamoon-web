<?php 
$email = $_GET['email']; 
$codigo = $_GET['code'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código de Recuperación - La Dulce Migaja</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="brand-title">¡Código Generado! 🧁</h1>
            <p style="margin-bottom: 20px;">Simulando envío a: <strong><?php echo $email; ?></strong></p>
            
            <div style="background: #ffe6ea; border: 2px dashed #d81b60; padding: 20px; border-radius: 15px; margin-bottom: 25px;">
                <span style="font-size: 14px; color: #ad1457; display: block; margin-bottom: 10px;">Tu código de acceso es:</span>
                <strong style="font-size: 35px; color: #d81b60; letter-spacing: 8px;"><?php echo $codigo; ?></strong>
            </div>

            <p class="welcome-text">Copia este código y úsalo para cambiar tu contraseña.</p>

            <a href="verificar_codigo.php?email=<?php echo urlencode($email); ?>" class="btn">Ir a Verificar Código</a>
        </div>
    </div>
</body>
</html>