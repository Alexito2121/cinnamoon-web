<?php
session_start();
include 'conexion.php';

// 1. Validar ID antes de procesar nada
if (!isset($_GET['id'])) {
    header("Location: ver_inventario.php");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

// 2. Obtener datos actuales del producto
$res = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
$p = mysqli_fetch_assoc($res);

if (!$p) {
    header("Location: ver_inventario.php");
    exit();
}

// 3. Procesar el Formulario (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $stock  = mysqli_real_escape_string($conexion, $_POST['stock']); 
    $stock_limite = mysqli_real_escape_string($conexion, $_POST['stock_limite']);
    
    $imagen_db = $p['imagen']; 

    if (!empty($_FILES['imagen_archivo']['name'])) {
        $nombre_foto = $_FILES['imagen_archivo']['name'];
        $ruta_temporal = $_FILES['imagen_archivo']['tmp_name'];
        $nueva_ruta = "imagen/" . time() . "_" . $nombre_foto;
        if (move_uploaded_file($ruta_temporal, $nueva_ruta)) {
            $imagen_db = $nueva_ruta;
        }
    }

    $sql = "UPDATE productos SET 
            nombre = '$nombre', 
            precio = '$precio', 
            imagen = '$imagen_db', 
            stock = '$stock', 
            stock_limite = '$stock_limite' 
            WHERE id = $id";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ver_inventario.php?update=success");
        exit();
    } else {
        $error = "Error al guardar: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar | Cinnamoon</title>
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
            gap: 22px;
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

        .img-wrap {
            position: relative;
            flex-shrink: 0;
            z-index: 1;
        }

        .img-wrap::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--caramel), transparent 60%);
            z-index: -1;
        }

        .preview-img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 14px;
            display: block;
            border: 2px solid rgba(255,255,255,0.12);
        }

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

        /* ── ERROR ── */
        .error-msg {
            background: rgba(214,48,49,0.08);
            border: 1px solid rgba(214,48,49,0.2);
            color: #d63031;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── FORM FIELDS ── */
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
            color: var(--espresso);
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: var(--caramel);
            box-shadow: 0 0 0 4px rgba(191,126,70,0.1);
        }

        /* Stock row */
        .stock-row {
            display: flex;
            gap: 12px;
        }

        .stock-row .sub-label {
            font-size: 0.65rem;
            color: #b09070;
            font-weight: 600;
            margin-bottom: 5px;
            margin-left: 2px;
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

        .file-label i {
            color: var(--caramel);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .file-text {
            font-size: 0.82rem;
            color: #a07850;
            font-weight: 600;
        }

        input[type="file"] { display: none; }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: rgba(76,43,8,0.07);
            margin: 20px 0;
        }

        /* ── SUBMIT ── */
        .btn-update {
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

        .btn-update::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.07));
        }

        .btn-update:hover {
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
        <div class="img-wrap">
            <img src="<?php echo $p['imagen']; ?>" class="preview-img" alt="Producto" id="previewImg">
        </div>
        <div class="header-text">
            <div class="header-eyebrow">Cinamoon · Admin</div>
            <h2>Editar Dulce</h2>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body">

        <?php if (isset($error)): ?>
            <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="input-group">
                <label>Nombre del Producto</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($p['nombre']); ?>" required>
            </div>

            <div class="input-group">
                <label>Precio (RD$)</label>
                <input type="number" name="precio" value="<?php echo $p['precio']; ?>" required>
            </div>

            <div class="input-group">
                <label>Nueva Foto <span style="font-weight:500;text-transform:none;letter-spacing:0;">(Opcional)</span></label>
                <label class="file-label" for="imagen_archivo">
                    <i class="fa-solid fa-image"></i>
                    <span class="file-text" id="fileName">Seleccionar imagen…</span>
                </label>
                <input type="file" name="imagen_archivo" id="imagen_archivo" accept="image/*">
            </div>

            <div class="input-group">
                <label>Stock e Inventario</label>
                <div class="stock-row">
                    <div style="flex:1;">
                        <div class="sub-label">Cantidad actual</div>
                        <input type="number" name="stock" value="<?php echo $p['stock']; ?>" min="0" required placeholder="Cant.">
                    </div>
                    <div style="flex:1;">
                        <div class="sub-label">Límite de alerta</div>
                        <input type="number" name="stock_limite" value="<?php echo $p['stock_limite']; ?>" min="0" required placeholder="Límite">
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <button type="submit" class="btn-update">
                <i class="fa-solid fa-floppy-disk"></i>
                Actualizar Cambios
            </button>
        </form>

        <a href="ver_inventario.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Volver al Inventario
        </a>

    </div>
</div>

<script>
    // Preview imagen al seleccionar
    document.getElementById('imagen_archivo').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            document.getElementById('fileName').textContent = file.name;
            const reader = new FileReader();
            reader.onload = e => document.getElementById('previewImg').src = e.target.result;
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>