<?php
session_start();
if (!isset($_SESSION['codigo_validado'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Clave - La Dulce Migaja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .error-clave { color: #ff5252; font-size: 12px; margin-top: -10px; margin-bottom: 15px; display: none; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 style="font-family: 'Pacifico', cursive; color: #d81b60; margin-bottom: 10px;">Nueva Clave 🔑</h1>
            <p style="font-size: 14px; color: #777; margin-bottom: 25px;">Crea una contraseña nueva y confírmala.</p>

            <form action="actualizar_clave.php" method="POST" id="formClave" autocomplete="off">
                <div class="input-group">
                    <label>Contraseña Nueva</label>
                    <input type="password" name="password" id="p1" placeholder="••••••••" required autocomplete="new-password">
                </div>

                <div class="input-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" id="p2" placeholder="••••••••" required autocomplete="new-password">
                </div>

                <p id="msgError" class="error-clave">❌ Las contraseñas no coinciden</p>
                
                <button type="submit" class="btn" id="btnOk">Actualizar Acceso</button>
            </form>
        </div>
    </div>

    <script>
        const p1 = document.getElementById('p1');
        const p2 = document.getElementById('p2');
        const btn = document.getElementById('btnOk');
        const msg = document.getElementById('msgError');

        function validar() {
            if (p1.value !== p2.value && p2.value !== "") {
                msg.style.display = "block";
                btn.style.opacity = "0.5";
                btn.style.pointerEvents = "none";
            } else {
                msg.style.display = "none";
                btn.style.opacity = "1";
                btn.style.pointerEvents = "auto";
            }
        }
        p1.addEventListener('input', validar);
        p2.addEventListener('input', validar);
    </script>
</body>
</html>