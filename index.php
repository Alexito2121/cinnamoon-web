<?php
session_start();
if (isset($_SESSION['usuario_id'])) { header("Location: admin.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        :root {
            --sky: #D0E3FF;
            --espresso: #4C2B08;
            --caramel: #BF7E46;
            --milky: #FFF9F0;
            --caramel-light: rgba(191,126,70,0.12);
            --espresso-light: rgba(76,43,8,0.07);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
            background: var(--milky);
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 52%;
            background: var(--espresso);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -100px; left: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(191,126,70,0.25) 0%, transparent 65%);
            border-radius: 50%;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(191,126,70,0.18) 0%, transparent 65%);
            border-radius: 50%;
        }

        /* Floating circles decoration */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(191,126,70,0.2);
            animation: float 6s ease-in-out infinite;
        }
        .deco-circle:nth-child(1) { width: 80px; height: 80px; top: 22%; right: 15%; animation-delay: 0s; }
        .deco-circle:nth-child(2) { width: 40px; height: 40px; top: 38%; right: 30%; animation-delay: 1.5s; background: rgba(191,126,70,0.08); }
        .deco-circle:nth-child(3) { width: 120px; height: 120px; bottom: 28%; left: 10%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 2;
            animation: fadeDown 0.6s ease both;
        }

        .brand-logo {
            width: 48px; height: 48px;
            background: rgba(255,249,240,0.1);
            border-radius: 14px;
            border: 1px solid rgba(191,126,70,0.35);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }

        .brand-name {
            font-family: 'Pacifico', cursive;
            color: var(--milky);
            font-size: 1.6rem;
            letter-spacing: 0.5px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            animation: fadeUp 0.7s 0.2s ease both;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(191,126,70,0.18);
            border: 1px solid rgba(191,126,70,0.3);
            border-radius: 100px;
            padding: 6px 16px;
            font-size: 11.5px;
            font-weight: 700;
            color: #e8c49a;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .hero-tag span {
            width: 6px; height: 6px;
            background: var(--caramel);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--milky);
            line-height: 1.12;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .hero-title .accent {
            color: var(--caramel);
            font-family: 'Pacifico', cursive;
            font-size: 2.8rem;
        }

        .hero-desc {
            font-size: 14px;
            color: rgba(255,249,240,0.55);
            line-height: 1.75;
            max-width: 320px;
            font-weight: 500;
        }

        .left-footer {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 16px;
            animation: fadeUp 0.7s 0.4s ease both;
        }

        .avatar-stack {
            display: flex;
        }

        .avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            border: 2px solid var(--espresso);
            background: var(--caramel-light);
            border: 2px solid rgba(191,126,70,0.4);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #e8c49a;
            margin-left: -8px;
        }
        .avatar:first-child { margin-left: 0; }

        .footer-text {
            font-size: 12px;
            color: rgba(255,249,240,0.45);
            font-weight: 600;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 52px;
            background: var(--milky);
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background:
                radial-gradient(ellipse at 80% 10%, rgba(208,227,255,0.55) 0%, transparent 55%),
                radial-gradient(ellipse at 10% 90%, rgba(191,126,70,0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .form-container {
            width: 100%;
            max-width: 360px;
            position: relative;
            z-index: 1;
        }

        .form-header {
            margin-bottom: 36px;
            animation: fadeDown 0.6s 0.1s ease both;
        }

        .form-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--espresso);
            letter-spacing: -0.6px;
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 13.5px;
            color: var(--espresso);
            opacity: 0.5;
            font-weight: 500;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 16px;
            animation: fadeUp 0.5s ease both;
        }
        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--espresso);
            opacity: 0.6;
            margin-bottom: 8px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--caramel);
            opacity: 0.6;
            pointer-events: none;
            display: flex;
        }

        input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 1.5px solid rgba(76,43,8,0.1);
            border-radius: 14px;
            box-sizing: border-box;
            outline: none;
            background: white;
            font-family: inherit;
            font-size: 14px;
            color: var(--espresso);
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
            font-weight: 500;
        }

        input::placeholder {
            color: var(--espresso);
            opacity: 0.3;
            font-weight: 400;
        }

        input:focus {
            border-color: var(--caramel);
            background: white;
            box-shadow: 0 0 0 4px rgba(191,126,70,0.1);
        }

        .btn {
            background: var(--espresso);
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 14px;
            margin-top: 8px;
            cursor: pointer;
            font-weight: 800;
            font-size: 15px;
            font-family: inherit;
            letter-spacing: 0.2px;
            transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            animation: fadeUp 0.5s 0.4s ease both;
        }

        .btn svg { transition: transform 0.25s; }
        .btn:hover { background: var(--caramel); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(191,126,70,0.35); }
        .btn:hover svg { transform: translateX(4px); }
        .btn:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 24px 0;
            animation: fadeUp 0.5s 0.5s ease both;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(76,43,8,0.1);
        }
        .divider span {
            font-size: 11.5px;
            color: var(--espresso);
            opacity: 0.35;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .links {
            text-align: center;
            animation: fadeUp 0.5s 0.55s ease both;
        }

        .links a {
            color: var(--espresso);
            text-decoration: none;
            font-weight: 700;
            font-size: 13.5px;
            opacity: 0.5;
            transition: opacity 0.2s, color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .links a:hover { opacity: 1; color: var(--caramel); }

        /* Animations */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mobile */
        @media (max-width: 720px) {
            body { flex-direction: column; overflow: auto; }
            .left-panel {
                width: 100%;
                padding: 36px 32px 40px;
                min-height: auto;
            }
            .hero-title { font-size: 2.2rem; }
            .hero-title .accent { font-size: 2rem; }
            .left-footer { display: none; }
            .right-panel { padding: 40px 28px; }
        }
    </style>
</head>
<body>

    <!-- ── LEFT PANEL ── -->
    <div class="left-panel">
        <div class="deco-circle"></div>
        <div class="deco-circle"></div>
        <div class="deco-circle"></div>

        <div class="brand">
            <div class="brand-logo">
                <img src="IMALOGO-removebg-preview.png" alt="Logo" style="width:32px; border-radius:6px;">
            </div>
            <span class="brand-name">Cinnamoon</span>
        </div>

        <div class="hero-content">
            <div class="hero-tag">
                <span></span>
                Panel de administración
            </div>
            <h1 class="hero-title">
                Bienvenido<br>de vuelta,<br>
                <span class="accent">equipo 🧁</span>
            </h1>
            <p class="hero-desc">
                Gestiona pedidos, productos y clientes desde un solo lugar. Rápido, seguro y hecho para ti.
            </p>
        </div>

        <div class="left-footer">
            <div class="avatar-stack">
                <div class="avatar">AN</div>
                <div class="avatar">MR</div>
                <div class="avatar">LC</div>
            </div>
            <p class="footer-text">Acceso exclusivo para el equipo Cinnamoon</p>
        </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="right-panel">
        <div class="form-container">

            <div class="form-header">
                <h2>Iniciar sesión</h2>
                <p>Ingresa tus credenciales para<br>acceder al panel.</p>
            </div>

            <form action="login_proceso.php" method="POST">

                <div class="form-group">
                    <label>Correo electrónico</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="4" width="20" height="16" rx="3"/><path d="m2 7 10 7 10-7"/>
                            </svg>
                        </span>
                        <input type="email" name="email" required placeholder="tu@correo.com">
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input type="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn">
                    Entrar al Panel
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </button>

            </form>

            <div class="divider"><span>o</span></div>

            <div class="links">
                <a href="home.php">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 12H5M11 6l-6 6 6 6"/>
                    </svg>
                    Volver a la Tienda
                </a>
            </div>

        </div>
    </div>

</body>
</html>