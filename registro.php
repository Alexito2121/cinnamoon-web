<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Ingreso | Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --sky: #D0E3FF;
            --espresso: #4C2B08;
            --caramel: #BF7E46;
            --milky: #FFF9F0;
            --shadow-warm: rgba(76, 43, 8, 0.13);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--sky);
            background-image:
                radial-gradient(ellipse at 15% 30%, rgba(191,126,70,0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 85% 70%, rgba(76,43,8,0.07) 0%, transparent 50%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        /* ── CARD ── */
        .card {
            width: 100%;
            max-width: 440px;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 24px 60px var(--shadow-warm);
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── HEADER ── */
        .card-header {
            background: var(--espresso);
            padding: 32px 36px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(191,126,70,0.18) 0%, transparent 70%);
            border-radius: 50%;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 150px; height: 150px;
            background: radial-gradient(circle, rgba(208,227,255,0.07) 0%, transparent 70%);
            border-radius: 50%;
        }

        .logo-wrap {
            position: relative;
            z-index: 1;
            display: inline-block;
            margin-bottom: 12px;
        }

        .logo-wrap::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--caramel), transparent 60%);
            z-index: -1;
        }

        .logo-img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 16px;
            display: block;
            border: 2px solid rgba(255,255,255,0.12);
        }

        .brand {
            font-family: 'Pacifico', cursive;
            color: #fff;
            font-size: 1.8rem;
            position: relative;
            z-index: 1;
            margin-bottom: 4px;
        }

        .tagline {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--caramel);
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .tagline::before, .tagline::after {
            content: '';
            display: inline-block;
            width: 20px; height: 1px;
            background: var(--caramel);
            opacity: 0.5;
        }

        /* ── BODY ── */
        .card-body {
            background: var(--milky);
            padding: 30px 36px 36px;
        }

        /* ── FIELDS ── */
        .field { margin-bottom: 14px; }

        .field > label {
            display: block;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.13em;
            color: var(--caramel);
            margin-bottom: 7px;
            margin-left: 2px;
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-box i {
            position: absolute;
            left: 14px;
            font-size: 0.8rem;
            color: var(--caramel);
            opacity: 0.7;
            pointer-events: none;
        }

        .input-box input {
            width: 100%;
            padding: 12px 16px 12px 38px;
            border: 2px solid rgba(76,43,8,0.1);
            border-radius: 14px;
            font-size: 0.88rem;
            font-family: inherit;
            font-weight: 500;
            color: var(--espresso);
            background: white;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-box input::placeholder { color: #c4a882; }

        .input-box input:focus {
            border-color: var(--caramel);
            box-shadow: 0 0 0 4px rgba(191,126,70,0.1);
        }

        .input-box input:disabled {
            background: rgba(76,43,8,0.04);
            color: #b09070;
            cursor: not-allowed;
        }

        /* ── PASSWORD METER ── */
        .meter {
            height: 4px;
            background: rgba(76,43,8,0.08);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 7px;
        }

        .bar {
            height: 100%;
            width: 0;
            border-radius: 10px;
            transition: width 0.4s ease, background 0.4s ease;
        }

        /* ── ERROR TEXT ── */
        .error-txt {
            color: #d63031;
            font-size: 0.72rem;
            font-weight: 700;
            margin-top: 6px;
            margin-left: 2px;
            display: none;
            align-items: center;
            gap: 5px;
        }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: rgba(76,43,8,0.07);
            margin: 18px 0;
        }

        /* ── SUBMIT ── */
        .btn-reg {
            width: 100%;
            padding: 14px;
            background: var(--espresso);
            color: white;
            border: none;
            border-radius: 15px;
            font-family: inherit;
            font-size: 0.88rem;
            font-weight: 800;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .btn-reg::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.07));
        }

        .btn-reg:hover:not(:disabled) {
            background: var(--caramel);
            transform: translateY(-3px);
            box-shadow: 0 10px 26px rgba(191,126,70,0.35);
        }

        .btn-reg:disabled {
            opacity: 0.35;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ── BACK ── */
        .back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 16px;
            color: #b09070;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            transition: color 0.2s;
        }

        .back:hover { color: var(--espresso); }

        @media (max-width: 480px) {
            .card-header { padding: 26px 22px 22px; }
            .card-body { padding: 24px 22px 30px; }
        }
    </style>
</head>
<body>

<div class="card">

    <!-- HEADER -->
    <div class="card-header">
        <div class="logo-wrap">
            <img src="IMALOGO-removebg-preview.png" alt="Logo" class="logo-img">
        </div>
        <h1 class="brand">Cinnamoon</h1>
        <p class="tagline">Registro de Equipo</p>
    </div>

    <!-- BODY -->
    <div class="card-body">
        <form action="insertar_usuario.php" method="POST">

            <div class="field">
                <label>Nombre Completo</label>
                <div class="input-box">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nombre" placeholder="Tu nombre completo" required>
                </div>
            </div>

            <div class="field">
                <label>Correo Electrónico</label>
                <div class="input-box">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="correo@ejemplo.com" required>
                </div>
            </div>

            <div class="field">
                <label>WhatsApp</label>
                <div class="input-box">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="telefono" id="tel" maxlength="12" placeholder="000-000-0000" required>
                </div>
            </div>

            <div class="field">
                <label>Contraseña</label>
                <div class="input-box">
                    <i class="fa-solid fa-key"></i>
                    <input type="password" name="password" id="p1" placeholder="Mínimo 4 caracteres" required>
                </div>
                <div class="meter"><div id="bar" class="bar"></div></div>
            </div>

            <div class="field">
                <label>Confirmar Contraseña</label>
                <div class="input-box">
                    <i class="fa-solid fa-shield-halved"></i>
                    <input type="password" name="confirm_password" id="p2" placeholder="Repite tu contraseña" required disabled>
                </div>
                <p id="err" class="error-txt"><i class="fa-solid fa-circle-exclamation"></i> Las claves no coinciden</p>
            </div>

            <div class="divider"></div>

            <button type="submit" id="btn" class="btn-reg" disabled>
                <i class="fa-solid fa-user-plus"></i> Crear Cuenta
            </button>
        </form>

        <a href="ver_cuentas.php" class="back">
            <i class="fa-solid fa-arrow-left"></i> Volver al Listado
        </a>
    </div>
</div>

<script>
    // Formato teléfono
    const telInput = document.getElementById('tel');
    telInput.addEventListener('input', (e) => {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
    });

    const p1 = document.getElementById('p1');
    const p2 = document.getElementById('p2');
    const btn = document.getElementById('btn');
    const bar = document.getElementById('bar');
    const err = document.getElementById('err');

    // Medidor de fortaleza
    p1.addEventListener('input', () => {
        let v = p1.value, s = 0;
        if (v.length > 5) s += 40;
        if (/[A-Z]/.test(v)) s += 30;
        if (/[0-9]/.test(v)) s += 30;
        bar.style.width = s + '%';
        bar.style.background = s < 50 ? '#d63031' : s < 90 ? '#e17055' : '#00b894';
        p2.disabled = v.length < 4;
        validar();
    });

    // Validación coincidencia
    const validar = () => {
        const match = p1.value === p2.value && p1.value !== '';
        err.style.display = (p2.value && !match) ? 'flex' : 'none';
        btn.disabled = !match;
    };

    p1.addEventListener('input', validar);
    p2.addEventListener('input', validar);
</script>

</body>
</html>