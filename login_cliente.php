<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar | Cliente Fiel</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;700&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { 
            --sky: #D0E3FF; 
            --espresso: #4C2B08; 
            --caramel: #BF7E46; 
            --caramel-light: #E8A96A;
            --milky: #FFF9F0; 
            --warm-white: #FFFCF7;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body { 
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
        }

        /* ══════════════════════
           LEFT — Decorative
        ══════════════════════ */
        .left-panel {
            background: var(--milky);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            overflow: hidden;
            border-right: 1px solid rgba(191,126,70,0.12);
        }

        /* Soft sky blob top-left */
        .left-panel::before {
            content: '';
            position: absolute;
            top: -120px; left: -120px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(208,227,255,0.7) 0%, transparent 70%);
            pointer-events: none;
        }
        /* Caramel blob bottom-right */
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -100px; right: -100px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(191,126,70,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .left-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .logo {
            width: 120px;
            filter: drop-shadow(0 15px 30px rgba(76,43,8,0.12));
            margin-bottom: 28px;
            animation: floatLogo 4s ease-in-out infinite;
        }
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-9px); }
        }

        .left-brand {
            font-family: 'Pacifico', cursive;
            font-size: 3rem;
            color: var(--espresso);
            margin-bottom: 6px;
        }
        .left-sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.15rem;
            color: var(--caramel);
            letter-spacing: 0.07em;
            margin-bottom: 50px;
        }

        /* Benefits list */
        .benefit-list {
            list-style: none;
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .benefit-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: white;
            border-radius: 16px;
            border: 1px solid rgba(191,126,70,0.1);
            transition: transform 0.25s;
        }
        .benefit-item:hover { transform: translateX(5px); }
        .benefit-icon {
            width: 38px; height: 38px;
            background: rgba(191,126,70,0.1);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--caramel);
            font-size: 14px;
            flex-shrink: 0;
        }
        .benefit-text strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--espresso);
            margin-bottom: 1px;
        }
        .benefit-text span {
            font-size: 11px;
            color: #aaa;
        }

        /* Bottom tag */
        .left-bottom-tag {
            position: absolute;
            bottom: 32px;
            left: 0; right: 0;
            text-align: center;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(76,43,8,0.25);
        }

        /* ══════════════════════
           RIGHT — Form
        ══════════════════════ */
        .right-panel {
            background: var(--warm-white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 65px;
            position: relative;
            overflow: hidden;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(208,227,255,0.5) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Back link */
        .back-link {
            position: absolute;
            top: 32px; left: 40px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            color: #bbb;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--caramel); }
        .back-link i { font-size: 11px; }

        .form-header {
            margin-bottom: 44px;
            position: relative;
            z-index: 1;
            opacity: 0;
            animation: slideUp 0.5s ease 0.05s forwards;
        }
        .form-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-eyebrow::after {
            content: '';
            width: 40px; height: 1px;
            background: var(--caramel);
            opacity: 0.4;
        }
        .form-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem;
            font-weight: 600;
            color: var(--espresso);
            line-height: 1.1;
        }
        .form-title em { font-style: italic; color: var(--caramel); }
        .form-desc {
            font-size: 14px;
            color: #aaa;
            margin-top: 10px;
            font-weight: 400;
        }

        /* ── FORM FIELDS ── */
        form {
            position: relative;
            z-index: 1;
        }

        .input-group { 
            position: relative; 
            margin-bottom: 18px;
            opacity: 0;
            animation: slideUp 0.5s ease forwards;
        }
        .input-group:nth-child(1) { animation-delay: 0.15s; }
        .input-group:nth-child(2) { animation-delay: 0.22s; }

        .input-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--espresso);
            opacity: 0.5;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }
        .input-wrap i { 
            position: absolute; 
            left: 18px; 
            top: 50%;
            transform: translateY(-50%);
            color: var(--caramel);
            font-size: 14px;
            pointer-events: none;
        }
        
        input[type="email"],
        input[type="password"] { 
            width: 100%; 
            padding: 15px 18px 15px 46px; 
            border-radius: 16px; 
            border: 1.5px solid rgba(76,43,8,0.1); 
            background: white; 
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            outline: none; 
            transition: all 0.25s; 
            color: var(--espresso);
        }
        input[type="email"]:focus,
        input[type="password"]:focus { 
            border-color: var(--caramel); 
            box-shadow: 0 0 0 4px rgba(191,126,70,0.08);
        }
        input::placeholder { color: #ccc; }

        .btn-login { 
            width: 100%; 
            background: var(--espresso); 
            color: white; 
            border: none; 
            padding: 16px; 
            border-radius: 16px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: all 0.3s; 
            font-size: 14px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
            opacity: 0;
            animation: slideUp 0.5s ease 0.3s forwards;
        }
        .btn-login:hover { 
            background: var(--caramel);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76,43,8,0.18);
        }

        .footer-links { 
            margin-top: 30px; 
            font-size: 13px; 
            color: #bbb;
            text-align: center;
            line-height: 2;
            position: relative;
            z-index: 1;
            opacity: 0;
            animation: slideUp 0.5s ease 0.38s forwards;
        }
        .footer-links a { 
            color: var(--caramel); 
            text-decoration: none; 
            font-weight: 700; 
            transition: opacity 0.2s;
        }
        .footer-links a:hover { opacity: 0.7; }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 24px 0 20px;
            opacity: 0;
            animation: slideUp 0.5s ease 0.28s forwards;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(76,43,8,0.08);
        }
        .divider span {
            font-size: 11px;
            color: #ccc;
            font-weight: 600;
            letter-spacing: 0.08em;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 60px 30px; }
        }
    </style>
</head>
<body>

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="left-content">
            <img src="IMALOGO-removebg-preview.png" class="logo" alt="Logo Cinnamoon">
            <div class="left-brand">Cinnamoon</div>
            <div class="left-sub">Tu rincón de dulces favorito</div>

            <ul class="benefit-list">
                <li class="benefit-item">
                    <div class="benefit-icon"><i class="fa-solid fa-percent"></i></div>
                    <div class="benefit-text">
                        <strong>10% de descuento</strong>
                        <span>En cada compra que realices</span>
                    </div>
                </li>
                <li class="benefit-item">
                    <div class="benefit-icon"><i class="fa-solid fa-star"></i></div>
                    <div class="benefit-text">
                        <strong>Acumula puntos</strong>
                        <span>Por cada dulce que pidas</span>
                    </div>
                </li>
                <li class="benefit-item">
                    <div class="benefit-icon"><i class="fa-solid fa-crown"></i></div>
                    <div class="benefit-text">
                        <strong>Postres exclusivos</strong>
                        <span>Solo para clientes fieles</span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="left-bottom-tag">Repostería Artesanal · Santo Domingo</div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <a href="acceso.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Volver</a>

        <div class="form-header">
            <div class="form-eyebrow">Cliente Fiel</div>
            <h1 class="form-title">¡Hola de<br><em>nuevo!</em></h1>
            <p class="form-desc">Inicia sesión para usar tus beneficios.</p>
        </div>

        <form action="procesar_login_cliente.php" method="POST">
            <div class="input-group">
                <label class="input-label">Correo electrónico</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="tu@correo.com" required>
                </div>
            </div>
            <div class="input-group">
                <label class="input-label">Contraseña</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesión
            </button>
        </form>

        <div class="divider"><span>¿Nuevo por aquí?</span></div>

        <div class="footer-links">
            ¿Aún no eres cliente fiel? <a href="registro_cliente.php">Regístrate aquí</a>
        </div>
    </div>

</body>
</html>