<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Cliente Fiel</title>
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
           LEFT — Form
        ══════════════════════ */
        .left-panel {
            background: var(--warm-white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 65px;
            position: relative;
            overflow: hidden;
            overflow-y: auto;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            bottom: -100px; left: -100px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(208,227,255,0.55) 0%, transparent 70%);
            pointer-events: none;
        }

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
            margin-bottom: 36px;
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
            font-size: 2.6rem;
            font-weight: 600;
            color: var(--espresso);
            line-height: 1.1;
        }
        .form-title em { font-style: italic; color: var(--caramel); }
        .form-desc {
            font-size: 13px;
            color: #aaa;
            margin-top: 10px;
        }

        /* Promo pill */
        .promo-box {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: rgba(191,126,70,0.1);
            border: 1px solid rgba(191,126,70,0.25);
            color: var(--caramel);
            font-size: 12px;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 50px;
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
            opacity: 0;
            animation: slideUp 0.5s ease 0.1s forwards;
        }
        .promo-dot {
            width: 7px; height: 7px;
            background: var(--caramel);
            border-radius: 50%;
        }

        /* ── FORM FIELDS ── */
        form { position: relative; z-index: 1; }

        .input-group { 
            position: relative; 
            margin-bottom: 14px;
            opacity: 0;
            animation: slideUp 0.45s ease forwards;
        }
        .input-group:nth-child(1) { animation-delay: 0.16s; }
        .input-group:nth-child(2) { animation-delay: 0.21s; }
        .input-group:nth-child(3) { animation-delay: 0.26s; }
        .input-group:nth-child(4) { animation-delay: 0.31s; }

        .input-label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--espresso);
            opacity: 0.45;
            margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-wrap i { 
            position: absolute; 
            left: 17px; 
            top: 50%;
            transform: translateY(-50%);
            color: var(--caramel);
            font-size: 13px;
            pointer-events: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] { 
            width: 100%; 
            padding: 14px 18px 14px 44px; 
            border-radius: 15px; 
            border: 1.5px solid rgba(76,43,8,0.1); 
            background: white; 
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            outline: none; 
            transition: all 0.25s; 
            color: var(--espresso);
        }
        input:focus { 
            border-color: var(--caramel); 
            box-shadow: 0 0 0 4px rgba(191,126,70,0.08);
        }
        input::placeholder { color: #ccc; }

        .btn-reg { 
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
            margin-top: 6px;
            opacity: 0;
            animation: slideUp 0.5s ease 0.36s forwards;
        }
        .btn-reg:hover { 
            background: var(--caramel);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76,43,8,0.18);
        }

        .footer-links { 
            margin-top: 24px; 
            font-size: 13px; 
            color: #bbb;
            text-align: center;
            line-height: 2;
            position: relative;
            z-index: 1;
            opacity: 0;
            animation: slideUp 0.5s ease 0.42s forwards;
        }
        .footer-links a { 
            color: var(--caramel); 
            text-decoration: none; 
            font-weight: 700; 
            transition: opacity 0.2s;
        }
        .footer-links a:hover { opacity: 0.7; }

        /* ══════════════════════
           RIGHT — Decorative
        ══════════════════════ */
        .right-panel {
            background: var(--espresso);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            overflow: hidden;
        }

        /* Rings */
        .ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.06);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
        .ring-1 { width: 650px; height: 650px; }
        .ring-2 { width: 470px; height: 470px; border-color: rgba(255,255,255,0.08); }
        .ring-3 { width: 290px; height: 290px; border-color: rgba(255,255,255,0.1); }

        .right-glow {
            position: absolute;
            width: 380px; height: 380px;
            background: radial-gradient(circle, rgba(191,126,70,0.2) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .right-top-tag {
            position: absolute;
            top: 36px; right: 36px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
        }

        .right-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .logo {
            width: 115px;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.35));
            margin-bottom: 26px;
            animation: floatLogo 4s ease-in-out infinite;
        }
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .right-brand {
            font-family: 'Pacifico', cursive;
            font-size: 3.2rem;
            color: white;
            margin-bottom: 6px;
        }
        .right-sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.1rem;
            color: var(--caramel-light);
            letter-spacing: 0.07em;
            margin-bottom: 55px;
        }

        /* Step cards */
        .steps {
            display: flex;
            flex-direction: column;
            gap: 14px;
            text-align: left;
            width: 100%;
            max-width: 300px;
        }
        .step {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            transition: background 0.25s;
        }
        .step:hover { background: rgba(255,255,255,0.09); }
        .step-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--caramel-light);
            line-height: 1;
            width: 28px;
            flex-shrink: 0;
        }
        .step-text strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: white;
            margin-bottom: 2px;
        }
        .step-text span {
            font-size: 11px;
            color: rgba(255,255,255,0.35);
        }

        .right-bottom-tag {
            position: absolute;
            bottom: 32px;
            left: 0; right: 0;
            text-align: center;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.15);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .right-panel { display: none; }
            .left-panel { padding: 60px 28px; }
        }
    </style>
</head>
<body>

    <!-- LEFT — Form -->
    <div class="left-panel">
        <a href="acceso.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Volver</a>

        <div class="form-header">
            <div class="form-eyebrow">Nuevo registro</div>
            <h1 class="form-title">Únete a<br>la <em>familia</em></h1>
            <p class="form-desc">Crea tu cuenta y empieza a disfrutar beneficios.</p>
        </div>

        <div class="promo-box">
            <div class="promo-dot"></div>
            <i class="fa-solid fa-gift"></i> 10% de descuento en tu primera compra
        </div>

        <form action="procesar_registro_cliente.php" method="POST">
            <div class="input-group">
                <label class="input-label">Nombre completo</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nombre" placeholder="Tu nombre" required>
                </div>
            </div>
            <div class="input-group">
                <label class="input-label">Correo electrónico</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="tu@correo.com" required>
                </div>
            </div>
            <div class="input-group">
                <label class="input-label">Teléfono / WhatsApp</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="telefono" placeholder="+1 (829) 000-0000" required>
                </div>
            </div>
            <div class="input-group">
                <label class="input-label">Contraseña</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn-reg">
                <i class="fa-solid fa-user-plus"></i> Registrarme ahora
            </button>
        </form>

        <div class="footer-links">
            ¿Ya tienes cuenta? <a href="login_cliente.php">Inicia sesión</a>
        </div>
    </div>

    <!-- RIGHT — Decorative -->
    <div class="right-panel">
        <div class="ring ring-1"></div>
        <div class="ring ring-2"></div>
        <div class="ring ring-3"></div>
        <div class="right-glow"></div>
        <div class="right-top-tag">Cliente Fiel</div>

        <div class="right-content">
            <img src="IMALOGO-removebg-preview.png" class="logo" alt="Logo Cinnamoon">
            <div class="right-brand">Cinnamoon</div>
            <div class="right-sub">Es fácil empezar</div>

            <div class="steps">
                <div class="step">
                    <div class="step-num">01</div>
                    <div class="step-text">
                        <strong>Crea tu cuenta</strong>
                        <span>Solo toma 30 segundos</span>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">02</div>
                    <div class="step-text">
                        <strong>Explora la vitrina</strong>
                        <span>Postres frescos cada día</span>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">03</div>
                    <div class="step-text">
                        <strong>Disfruta tu 10%</strong>
                        <span>Descuento desde el primer pedido</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-bottom-tag">Repostería Artesanal · Santo Domingo</div>
    </div>

</body>
</html>