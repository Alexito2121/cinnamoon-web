<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Éxito! - La Dulce Migaja</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .success-animation {
            font-size: 70px;
            display: block;
            margin-bottom: 20px;
            animation: popIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popIn {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .card-exito {
            border-top: 5px solid #d81b60; /* Un detalle rosa arriba */
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card card-exito">
            <span class="success-animation">🧁✨</span>
            
            <h1 class="brand-title">¡Todo listo!</h1>
            <h2 style="color: #2e7d32; font-size: 18px; margin-bottom: 15px;">Cambio completado</h2>
            
            <p style="color: #5d4037; font-size: 14px; line-height: 1.6; margin-bottom: 30px;">
                Tu contraseña ha sido actualizada con éxito. <br>
                Ya puedes volver a entrar a tu cocina favorita.
            </p>

            <a href="index.php" class="btn">Volver al Inicio</a>
        </div>
    </div>

</body>
</html>