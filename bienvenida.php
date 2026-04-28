<?php
session_start();
if (!isset($_SESSION['nombre_usuario'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida | Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Plus+Jakarta+Sans:wght@400;800&display=swap" rel="stylesheet">
    <style>
        body { background: #fdfaf5; font-family: 'Plus Jakarta Sans', sans-serif; height: 100vh; margin: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .shape-bg { position: absolute; top: -10%; left: -5%; width: 40%; height: 60%; background: #fcebd7; border-radius: 0 0 500px 500px; z-index: -1; transform: rotate(-15deg); }
        .card { background: white; padding: 60px; border-radius: 60px; text-align: center; box-shadow: 0 30px 60px rgba(74,44,42,0.1); max-width: 500px; position: relative; border: 1px solid #fcebd7; }
        .cake-icon { font-size: 4rem; margin-bottom: 20px; display: block; }
        h1 { font-family: 'Pacifico', cursive; color: #4a2c2a; font-size: 3rem; margin: 0; }
        p { color: #888; font-size: 1.2rem; line-height: 1.6; margin: 25px 0; }
        .btn { background: #4a2c2a; color: white; padding: 20px 45px; border-radius: 40px; text-decoration: none; font-weight: 800; display: inline-block; transition: 0.3s; box-shadow: 0 10px 20px rgba(74, 44, 42, 0.2); }
        .btn:hover { background: #d81b60; transform: scale(1.05); }
    </style>
</head>
<body>
    <div class="shape-bg"></div>
    <div class="card">
        <span class="cake-icon">🧁</span>
        <h1>¡Hola, <?php echo $_SESSION['nombre_usuario']; ?>!</h1>
        <p>Ya entraste a la cocina de Cinnamoon.<br>¡A hornear se ha dicho!</p>
        <a href="home.php" class="btn">ENTRAR A LA WEB</a>
    </div>
</body>
</html>