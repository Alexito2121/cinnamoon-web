<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'empleado')) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Dulce | Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
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
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 180px; height: 180px;
            background: radial-gradient(circle, rgba(191,126,70,0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .header-icon {
            flex-shrink: 0;
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            position: relative;
            z-index: 1;
        }

        /* Preview image inside icon when file selected */
        .header-icon img {
            width: 100%; height: 100%;
            object-fit: cover;
            border-radius: 16px;
            display: none;
        }

        .header-icon .icon-emoji { transition: opacity 0.2s; }

        .header-text { position: relative; z-index: 1; }

        .header-eyebrow {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .header-eyebrow::before {
            content: '';
            display: inline-block;
            width: 18px; height: 2px;
            background: var(--caramel);
            border-radius: 2px;
        }

        .card-header h2 {
            font-family: 'Pacifico', cursive;
            color: #fff;
            font-size: 1.6rem;
            line-height: 1.2;
        }

        /* ── BODY ── */
        .card-body {
            background: var(--milky);
            padding: 32px 36px 36px;
        }

        /* ── FIELDS ── */
        .input-group { margin-bottom: 16px; }

        label {
            display: block;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.13em;
            color: var(--caramel);
            margin-bottom: 7px;
            margin-left: 2px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid rgba(76,43,8,0.1);
            border-radius: 14px;
            outline: none;
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--espresso);
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="text"]::placeholder,
        input[type="number"]::placeholder { color: #c4a882; font-weight: 500; }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: var(--caramel);
            box-shadow: 0 0 0 4px rgba(191,126,70,0.1);
        }

        /* File input */
        .file-label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 2px dashed rgba(76,43,8,0.15);
            border-radius: 14px;
            background: white;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }

        .file-label:hover {
            border-color: var(--caramel);
            background: rgba(191,126,70,0.04);
        }

        .file-icon {
            width: 36px; height: 36px;
            background: rgba(191,126,70,0.1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--caramel);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .file-text {
            font-size: 0.82rem;
            color: #a07850;
            font-weight: 600;
        }

        input[type="file"] { display: none; }

        /* Stock row */
        .stock-row { display: flex; gap: 12px; }

        .stock-row > div { flex: 1; }

        .sub-label {
            font-size: 0.65rem;
            color: #b09070;
            font-weight: 600;
            margin-bottom: 5px;
            margin-left: 2px;
            display: block;
        }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: rgba(76,43,8,0.07);
            margin: 20px 0;
        }

        /* ── SUBMIT ── */
        .btn-save {
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

        .btn-save::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.07));
        }

        .btn-save:hover {
            background: var(--caramel);
            transform: translateY(-3px);
            box-shadow: 0 10px 26px rgba(191,126,70,0.35);
        }

        /* ── BACK ── */
        .btn-back {
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

        .btn-back:hover { color: var(--espresso); }

        @media (max-width: 480px) {
            .card-header { padding: 24px 22px; }
            .card-body { padding: 24px 22px 30px; }
        }
    </style>
</head>
<body>

<div class="card">

    <!-- HEADER -->
    <div class="card-header">
        <div class="header-icon" id="headerIcon">
            <span class="icon-emoji">🍬</span>
            <img id="previewImg" src="" alt="preview">
        </div>
        <div class="header-text">
            <div class="header-eyebrow">Cinamoon · Admin</div>
            <h2>Nuevo Dulce</h2>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body">
        <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">

            <div class="input-group">
                <label>Nombre del Dulce</label>
                <input type="text" name="nombre" placeholder="Ej. Brownie de Nutella" required>
            </div>

            <div class="input-group">
                <label>Precio (RD$)</label>
                <input type="number" name="precio" placeholder="0.00" required>
            </div>

            <div class="input-group">
                <label>Foto del Producto</label>
                <label class="file-label" for="imagen_archivo">
                    <div class="file-icon">📷</div>
                    <span class="file-text" id="fileName">Seleccionar imagen…</span>
                </label>
                <input type="file" name="imagen_archivo" id="imagen_archivo" accept="image/*" required>
            </div>

            <div class="input-group">
                <label>Stock e Inventario</label>
                <div class="stock-row">
                    <div>
                        <span class="sub-label">Cantidad inicial</span>
                        <input type="number" name="stock" placeholder="Cant." min="0" required>
                    </div>
                    <div>
                        <span class="sub-label">Límite de alerta</span>
                        <input type="number" name="stock_limite" placeholder="Aviso" min="0" required>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <button type="submit" class="btn-save">
                ✨ Guardar en Vitrina
            </button>
        </form>

        <a href="ver_inventario.php" class="btn-back">
            ← Volver al Inventario
        </a>
    </div>
</div>

<script>
    document.getElementById('imagen_archivo').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            document.getElementById('fileName').textContent = file.name;
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('previewImg');
                const emoji = document.querySelector('.icon-emoji');
                preview.src = e.target.result;
                preview.style.display = 'block';
                emoji.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>