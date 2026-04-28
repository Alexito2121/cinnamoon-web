<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido | Cinnamoon</title>
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
            --green: #2ecc71;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body { 
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
        }

        /* ══════════════════════════
           LEFT SIDE — Visual Panel
        ══════════════════════════ */
        .left-panel {
            background: var(--espresso);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            overflow: hidden;
        }

        /* Concentric circles deco */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 700px; height: 700px;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 50%;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 50%;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }
        .circle-inner {
            position: absolute;
            width: 300px; height: 300px;
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 50%;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Glow blob */
        .left-glow {
            position: absolute;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(191,126,70,0.25) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        /* Top label */
        .left-tag {
            position: absolute;
            top: 36px; left: 36px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
        }
        .left-tag::before {
            content: '';
            width: 18px; height: 1px;
            background: rgba(255,255,255,0.25);
        }

        .left-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .logo {
            width: 130px;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));
            margin-bottom: 24px;
            transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: floatLogo 4s ease-in-out infinite;
        }
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .brand-name {
            font-family: 'Pacifico', cursive;
            font-size: 3.8rem;
            color: white;
            line-height: 1;
            margin-bottom: 10px;
        }
        .brand-sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.2rem;
            color: var(--caramel-light);
            letter-spacing: 0.08em;
        }

        /* Stats at bottom */
        .left-stats {
            position: absolute;
            bottom: 40px;
            left: 0; right: 0;
            display: flex;
            justify-content: center;
            gap: 50px;
        }
        .left-stat {
            text-align: center;
        }
        .left-stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--caramel-light);
            line-height: 1;
        }
        .left-stat-label {
            font-size: 9px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            margin-top: 3px;
        }

        /* ══════════════════════════
           RIGHT SIDE — Options
        ══════════════════════════ */
        .right-panel {
            background: var(--warm-white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 55px;
            position: relative;
            overflow-y: auto;
        }

        /* Subtle top-right decoration */
        .right-panel::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(208,227,255,0.6) 0%, transparent 70%);
            pointer-events: none;
        }

        .right-header {
            margin-bottom: 48px;
            position: relative;
            z-index: 1;
        }
        .right-eyebrow {
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
        .right-eyebrow::after {
            content: '';
            flex: 1;
            max-width: 60px;
            height: 1px;
            background: var(--caramel);
            opacity: 0.35;
        }
        .right-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.6rem;
            font-weight: 600;
            color: var(--espresso);
            line-height: 1.15;
        }
        .right-title em {
            font-style: italic;
            color: var(--caramel);
        }

        /* ── OPTION CARDS ── */
        .option-box {
            background: var(--milky);
            border: 1.5px solid rgba(191,126,70,0.12);
            border-radius: 24px;
            padding: 24px 26px;
            margin-bottom: 16px;
            transition: all 0.32s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-align: left;
            position: relative;
            cursor: pointer;
            text-decoration: none;
            display: block;
            overflow: hidden;
        }
        .option-box::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 60%, rgba(191,126,70,0.04) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .option-box:hover::before { opacity: 1; }

        /* Arrow indicator */
        .option-box::after {
            content: '→';
            position: absolute;
            right: 26px;
            top: 50%;
            transform: translateY(-50%) translateX(8px);
            font-size: 18px;
            opacity: 0;
            transition: all 0.3s;
        }

        .opt-cliente { border-color: rgba(191,126,70,0.2); }
        .opt-cliente:hover { 
            border-color: var(--caramel); 
            transform: translateX(6px);
            box-shadow: 0 10px 30px rgba(191,126,70,0.12);
        }
        .opt-cliente:hover::after { color: var(--caramel); opacity: 1; transform: translateY(-50%) translateX(0); }

        .opt-invitado { border-color: rgba(76,43,8,0.1); }
        .opt-invitado:hover { 
            border-color: rgba(76,43,8,0.3); 
            transform: translateX(6px);
            box-shadow: 0 10px 30px rgba(76,43,8,0.07);
        }
        .opt-invitado:hover::after { color: var(--espresso); opacity: 0.5; transform: translateY(-50%) translateX(0); }

        .opt-admin { 
            border-color: rgba(76,43,8,0.06); 
            background: rgba(76,43,8,0.02);
        }
        .opt-admin:hover { 
            border-color: rgba(76,43,8,0.18); 
            transform: translateX(6px);
        }
        .opt-admin:hover::after { color: #888; opacity: 0.5; transform: translateY(-50%) translateX(0); }

        .opt-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }

        .opt-icon {
            width: 44px; height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
            transition: transform 0.3s;
        }
        .option-box:hover .opt-icon { transform: scale(1.1) rotate(-4deg); }

        .opt-cliente .opt-icon { background: rgba(191,126,70,0.12); color: var(--caramel); }
        .opt-invitado .opt-icon { background: rgba(76,43,8,0.08); color: var(--espresso); }
        .opt-admin .opt-icon { background: rgba(100,100,100,0.08); color: #888; }

        .opt-title { 
            font-weight: 700; 
            font-size: 15px;
            letter-spacing: 0.03em;
        }
        .opt-cliente .opt-title { color: var(--caramel); }
        .opt-invitado .opt-title { color: var(--espresso); }
        .opt-admin .opt-title { color: #888; }

        .benefits { 
            list-style: none; 
            font-size: 12.5px; 
            color: #999; 
            line-height: 1.7;
            padding-left: 58px;
        }
        .benefits li {
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .benefits li i { 
            color: var(--green); 
            font-size: 9px;
            flex-shrink: 0;
        }
        .opt-admin .benefits li i { color: #bbb; }

        /* Best value badge */
        .badge-discount {
            position: absolute;
            top: -1px;
            right: 22px;
            background: var(--caramel);
            color: white;
            font-size: 9px;
            font-weight: 800;
            padding: 5px 14px;
            border-radius: 0 0 12px 12px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* Animations */
        .option-box { 
            opacity: 0;
            animation: slideIn 0.5s ease forwards;
        }
        .option-box:nth-child(1) { animation-delay: 0.1s; }
        .option-box:nth-child(2) { animation-delay: 0.2s; }
        .option-box:nth-child(3) { animation-delay: 0.3s; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .right-header {
            opacity: 0;
            animation: slideIn 0.5s ease 0.05s forwards;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; grid-template-rows: auto 1fr; }
            .left-panel { padding: 50px 30px; min-height: 280px; }
            .left-stats { gap: 30px; }
            .brand-name { font-size: 2.8rem; }
            .right-panel { padding: 40px 28px; }
        }
    </style>
</head>
<body>

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="circle-inner"></div>
        <div class="left-glow"></div>
        <div class="left-tag">Santo Domingo · Rep. Dom.</div>

        <div class="left-content">
            <img src="IMALOGO-removebg-preview.png" class="logo" alt="Cinnamoon Logo">
            <div class="brand-name">Cinnamoon</div>
            <div class="brand-sub">Repostería 100% artesanal</div>
        </div>

        <div class="left-stats">
            <div class="left-stat">
                <div class="left-stat-num">100%</div>
                <div class="left-stat-label">Artesanal</div>
            </div>
            <div class="left-stat">
                <div class="left-stat-num">★ 5.0</div>
                <div class="left-stat-label">Calificación</div>
            </div>
            <div class="left-stat">
                <div class="left-stat-num">Fresh</div>
                <div class="left-stat-label">Del día</div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="right-header">
            <div class="right-eyebrow">Bienvenido</div>
            <h1 class="right-title">¿Cómo deseas<br>realizar tu <em>pedido</em>?</h1>
        </div>

        <a href="login_cliente.php" class="option-box opt-cliente">
            <span class="badge-discount">¡Ahorra más!</span>
            <div class="opt-top">
                <div class="opt-icon"><i class="fa-solid fa-crown"></i></div>
                <div class="opt-title">SOY CLIENTE FIEL</div>
            </div>
            <ul class="benefits">
                <li><i class="fa-solid fa-check"></i> 10% de descuento en cada compra.</li>
                <li><i class="fa-solid fa-check"></i> Acumula puntos por cada dulce.</li>
                <li><i class="fa-solid fa-check"></i> Acceso a postres exclusivos.</li>
            </ul>
        </a>

        <a href="home.php" class="option-box opt-invitado">
            <div class="opt-top">
                <div class="opt-icon"><i class="fa-solid fa-user-clock"></i></div>
                <div class="opt-title">COMPRAR COMO INVITADO</div>
            </div>
            <ul class="benefits">
                <li><i class="fa-solid fa-check"></i> Compra rápida sin registro.</li>
                <li><i class="fa-solid fa-check"></i> Precios estándar de vitrina.</li>
                <li><i class="fa-solid fa-check"></i> Ideal para antojos rápidos.</li>
            </ul>
        </a>

        <div onclick="accesoAdmin()" class="option-box opt-admin">
            <div class="opt-top">
                <div class="opt-icon"><i class="fa-solid fa-lock"></i></div>
                <div class="opt-title">PERSONAL / ADMIN</div>
            </div>
            <ul class="benefits">
                <li><i class="fa-solid fa-check"></i> Gestión de inventario y stock.</li>
                <li><i class="fa-solid fa-check"></i> Revisión de pedidos pendientes.</li>
                <li><i class="fa-solid fa-check"></i> Panel de control administrativo.</li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function accesoAdmin() {
            Swal.fire({
                title: 'Acceso Restringido',
                text: 'Ingresa el PIN de seguridad para continuar',
                input: 'password',
                inputPlaceholder: 'PIN',
                confirmButtonColor: '#4C2B08',
                showCancelButton: true,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value === 'alex1121') {
                    window.location.href = 'index.php';
                } else if (result.isConfirmed) {
                    Swal.fire({ icon: 'error', title: 'PIN Incorrecto', timer: 1500, showConfirmButton: false });
                }
            });
        }
    </script>
</body>
</html>