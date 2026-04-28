<?php
session_start();
include 'conexion.php';

// Definir el rol para las validaciones
$rol = $_SESSION['rol'] ?? 'cliente';

if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit;
}

$id_p = intval($_GET['id']);

// Obtener datos del producto
$res_p = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id_p");
$producto = mysqli_fetch_assoc($res_p);

if (!$producto) { header("Location: home.php"); exit; }

// Obtener todas las reseñas
$query_resenas = "SELECT * FROM reseñas WHERE id_producto = $id_p ORDER BY fecha DESC";
$resenas = mysqli_query($conexion, $query_resenas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas - <?php echo $producto['nombre']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root { 
            --sky: #D0E3FF; 
            --espresso: #4C2B08; 
            --caramel: #BF7E46; 
            --milky: #FFF9F0; 
            --red: #d63031;
            --espresso-light: #7a4a1a;
            --caramel-light: #d9a06a;
            --shadow-warm: rgba(76, 43, 8, 0.12);
            --shadow-caramel: rgba(191, 126, 70, 0.2);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body { 
            background: var(--sky);
            background-image: 
                radial-gradient(ellipse at 20% 20%, rgba(191, 126, 70, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(76, 43, 8, 0.06) 0%, transparent 50%);
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0; 
            padding: 0;
            min-height: 100vh;
        }

        /* ── PAGE LAYOUT ── */
        .page-wrapper {
            display: grid;
            grid-template-columns: 1fr min(820px, 100%) 1fr;
            padding: 50px 20px 80px;
            gap: 0;
        }

        .page-wrapper > * {
            grid-column: 2;
        }

        /* ── HERO HEADER ── */
        .hero {
            background: var(--espresso);
            border-radius: 32px 32px 0 0;
            padding: 50px 50px 40px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(191, 126, 70, 0.18) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 180px; height: 180px;
            background: radial-gradient(circle, rgba(208, 227, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-img-wrap {
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .hero-img-wrap::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 26px;
            background: linear-gradient(135deg, var(--caramel), transparent 60%);
            z-index: -1;
        }

        .producto-img { 
            width: 130px; 
            height: 130px; 
            object-fit: cover; 
            border-radius: 22px;
            border: 3px solid rgba(255,255,255,0.15);
            display: block;
        }

        .hero-text {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .hero-eyebrow {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .hero-eyebrow::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 2px;
            background: var(--caramel);
            border-radius: 2px;
        }

        .hero h1 { 
            font-family: 'Pacifico', cursive; 
            color: #fff;
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            margin: 0 0 12px;
            line-height: 1.2;
        }

        .hero-meta {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .reviews-count {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
        }

        .avg-stars {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .avg-stars .stars-row {
            color: #ffca08;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        /* ── BODY PANEL ── */
        .panel {
            background: var(--milky);
            padding: 40px 50px 50px;
            border-radius: 0 0 32px 32px;
            box-shadow: 0 25px 60px var(--shadow-warm);
        }

        /* ── SECTION LABEL ── */
        .section-label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .section-label span {
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--caramel);
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, rgba(191, 126, 70, 0.3), transparent);
        }

        /* ── REVIEW CARDS ── */
        .reviews-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .comentario-card { 
            background: white; 
            padding: 24px 28px; 
            border-radius: 20px; 
            position: relative; 
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: 1px solid rgba(76, 43, 8, 0.06);
            overflow: hidden;
        }

        .comentario-card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, var(--caramel), var(--espresso-light));
            border-radius: 4px 0 0 4px;
        }

        .comentario-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 12px 32px var(--shadow-caramel);
        }

        .card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--caramel), var(--espresso));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .user-name {
            color: var(--espresso); 
            font-size: 0.95rem;
            font-weight: 700;
        }

        .estrellas { 
            color: #ffca08; 
            font-size: 0.8rem;
            letter-spacing: 1px;
            display: flex;
            gap: 2px;
        }

        .review-body {
            color: #5a3d20;
            font-size: 0.92rem;
            line-height: 1.7;
            font-weight: 400;
            padding-left: 52px;
            position: relative;
        }

        .review-body::before {
            content: '\201C';
            font-family: Georgia, serif;
            font-size: 2.5rem;
            color: var(--caramel);
            opacity: 0.3;
            line-height: 1;
            position: absolute;
            left: 48px;
            top: -8px;
        }

        .review-text {
            position: relative;
            z-index: 1;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid rgba(76, 43, 8, 0.06);
        }

        .fecha { 
            font-size: 0.75rem;
            color: #b09070;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-eliminar { 
            background: none;
            border: 1px solid rgba(214, 48, 49, 0.2);
            color: var(--red); 
            font-size: 0.7rem;
            font-weight: 700; 
            display: flex; 
            align-items: center; 
            gap: 5px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 10px;
            transition: all 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .btn-eliminar:hover { 
            background: rgba(214, 48, 49, 0.08);
            border-color: var(--red);
            transform: scale(1.03);
        }

        /* ── EMPTY STATE ── */
        .vacio { 
            text-align: center; 
            padding: 60px 20px;
        }

        .vacio-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(191,126,70,0.12), rgba(76,43,8,0.06));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--caramel);
        }

        .vacio h3 {
            font-family: 'Pacifico', cursive;
            color: var(--espresso);
            font-size: 1.4rem;
            margin: 0 0 8px;
        }

        .vacio p {
            color: #a07850;
            font-size: 0.9rem;
            margin: 0;
            font-weight: 500;
        }

        /* ── ACTION BUTTONS ── */
        .actions {
            display: flex;
            gap: 14px;
            justify-content: center;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .btn-volver { 
            display: inline-flex; 
            align-items: center;
            gap: 9px;
            padding: 13px 28px; 
            background: var(--espresso); 
            color: white; 
            text-decoration: none; 
            border-radius: 16px; 
            font-weight: 700;
            font-size: 0.88rem;
            transition: all 0.25s;
            border: none; 
            cursor: pointer;
            letter-spacing: 0.02em;
            position: relative;
            overflow: hidden;
        }

        .btn-volver::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.08));
        }

        .btn-volver:hover { 
            transform: translateY(-3px);
            box-shadow: 0 10px 28px var(--shadow-warm);
        }

        .btn-volver.caramel {
            background: linear-gradient(135deg, var(--caramel), var(--espresso-light));
        }

        .btn-volver.caramel:hover {
            box-shadow: 0 10px 28px var(--shadow-caramel);
        }

        /* ── RATING SUMMARY BAR ── */
        .rating-summary {
            background: white;
            border-radius: 20px;
            padding: 22px 28px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 30px;
            border: 1px solid rgba(76, 43, 8, 0.06);
        }

        .rating-big {
            text-align: center;
            flex-shrink: 0;
        }

        .rating-number {
            font-family: 'Pacifico', cursive;
            font-size: 3.2rem;
            color: var(--espresso);
            line-height: 1;
            display: block;
        }

        .rating-stars-big {
            color: #ffca08;
            font-size: 1rem;
            margin: 6px 0 4px;
            letter-spacing: 2px;
        }

        .rating-label {
            font-size: 0.72rem;
            color: #b09070;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .rating-divider {
            width: 1px;
            height: 60px;
            background: rgba(76, 43, 8, 0.1);
            flex-shrink: 0;
        }

        .rating-bars {
            flex: 1;
        }

        .bar-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .bar-label {
            font-size: 0.72rem;
            color: #b09070;
            font-weight: 600;
            width: 14px;
            text-align: right;
            flex-shrink: 0;
        }

        .bar-track {
            flex: 1;
            height: 6px;
            background: rgba(76, 43, 8, 0.08);
            border-radius: 3px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 3px;
            background: linear-gradient(to right, var(--caramel), var(--espresso));
            transition: width 0.8s ease;
        }

        .bar-count {
            font-size: 0.7rem;
            color: #b09070;
            width: 20px;
            flex-shrink: 0;
            text-align: right;
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero { animation: fadeUp 0.4s ease both; }
        .panel { animation: fadeUp 0.4s 0.1s ease both; }
        .comentario-card:nth-child(1) { animation: fadeUp 0.4s 0.15s ease both; }
        .comentario-card:nth-child(2) { animation: fadeUp 0.4s 0.2s ease both; }
        .comentario-card:nth-child(3) { animation: fadeUp 0.4s 0.25s ease both; }
        .comentario-card:nth-child(4) { animation: fadeUp 0.4s 0.3s ease both; }
        .comentario-card:nth-child(5) { animation: fadeUp 0.4s 0.35s ease both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 600px) {
            .page-wrapper { padding: 24px 12px 50px; }
            .hero { padding: 30px 24px; gap: 20px; flex-direction: column; text-align: center; }
            .hero-eyebrow { justify-content: center; }
            .hero-meta { justify-content: center; }
            .panel { padding: 28px 20px 36px; }
            .review-body { padding-left: 0; }
            .review-body::before { display: none; }
            .rating-summary { flex-direction: column; gap: 16px; }
            .rating-divider { width: 80px; height: 1px; }
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <!-- HERO -->
    <div class="hero">
        <div class="hero-img-wrap">
            <img src="<?php echo $producto['imagen']; ?>" class="producto-img" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
        </div>
        <div class="hero-text">
            <div class="hero-eyebrow">Cinamoon · Opiniones</div>
            <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
            <div class="hero-meta">
                <?php
                $total = mysqli_num_rows($resenas);
                // Recalculate for avg
                $resenas_arr = [];
                $sum = 0;
                if ($total > 0) {
                    mysqli_data_seek($resenas, 0);
                    while ($row = mysqli_fetch_assoc($resenas)) {
                        $resenas_arr[] = $row;
                        $sum += $row['estrellas'];
                    }
                    mysqli_data_seek($resenas, 0);
                }
                $avg = $total > 0 ? round($sum / $total, 1) : 0;
                ?>
                <?php if ($total > 0): ?>
                <div class="avg-stars">
                    <div class="stars-row">
                        <?php for ($i = 1; $i <= 5; $i++) echo ($i <= $avg) ? '★' : '☆'; ?>
                    </div>
                </div>
                <span class="reviews-count"><?php echo $total; ?> opinión<?php echo $total !== 1 ? 'es' : ''; ?></span>
                <?php else: ?>
                <span class="reviews-count">Sin opiniones aún</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- MAIN PANEL -->
    <div class="panel">

        <?php if ($total > 0): ?>

        <!-- RATING SUMMARY -->
        <?php
        $counts = [5=>0,4=>0,3=>0,2=>0,1=>0];
        foreach ($resenas_arr as $rev) { $counts[$rev['estrellas']]++; }
        ?>
        <div class="rating-summary">
            <div class="rating-big">
                <span class="rating-number"><?php echo $avg; ?></span>
                <div class="rating-stars-big">
                    <?php for ($i = 1; $i <= 5; $i++) echo ($i <= round($avg)) ? '★' : '☆'; ?>
                </div>
                <span class="rating-label">de 5 estrellas</span>
            </div>
            <div class="rating-divider"></div>
            <div class="rating-bars">
                <?php foreach ([5,4,3,2,1] as $s): ?>
                <div class="bar-row">
                    <span class="bar-label"><?php echo $s; ?></span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width: <?php echo $total > 0 ? round(($counts[$s]/$total)*100) : 0; ?>%"></div>
                    </div>
                    <span class="bar-count"><?php echo $counts[$s]; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- REVIEWS LIST -->
        <div class="section-label">
            <span>Todas las opiniones</span>
        </div>

        <div class="reviews-list">
        <?php foreach ($resenas_arr as $r): ?>
            <div class="comentario-card">
                <div class="card-top">
                    <div class="user-info">
                        <div class="user-avatar"><?php echo strtoupper(mb_substr($r['usuario'], 0, 2)); ?></div>
                        <div class="user-details">
                            <span class="user-name"><?php echo htmlspecialchars($r['usuario']); ?></span>
                            <div class="estrellas">
                                <?php 
                                for ($i = 1; $i <= 5; $i++) {
                                    echo ($i <= $r['estrellas']) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($rol === 'admin'): ?>
                        <button class="btn-eliminar" onclick="confirmarBorrado(<?php echo $r['id']; ?>, <?php echo $id_p; ?>)">
                            <i class="fa-solid fa-trash-can"></i> Eliminar
                        </button>
                    <?php endif; ?>
                </div>

                <div class="review-body">
                    <p class="review-text" style="margin:0;"><?php echo htmlspecialchars($r['comentario']); ?></p>
                </div>

                <div class="card-footer">
                    <span class="fecha">
                        <i class="fa-regular fa-calendar"></i>
                        <?php echo date("d/m/Y · H:i", strtotime($r['fecha'])); ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <?php else: ?>
        <div class="vacio">
            <div class="vacio-icon"><i class="fa-regular fa-comment-dots"></i></div>
            <h3>Aún no hay opiniones</h3>
            <p>¡Sé el primero en compartir tu experiencia con este producto!</p>
        </div>
        <?php endif; ?>

        <!-- ACTIONS -->
        <div class="actions">
            <a href="home.php" class="btn-volver">
                <i class="fa-solid fa-house"></i> Volver al Inicio
            </a>
            <?php if ($rol == 'admin'): ?>
                <a href="admin.php" class="btn-volver caramel">
                    <i class="fa-solid fa-layer-group"></i> Panel Admin
                </a>
            <?php endif; ?>
        </div>

    </div><!-- /panel -->
</div><!-- /page-wrapper -->

<script>
function confirmarBorrado(idResena, idProducto) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta reseña desaparecerá de la vitrina.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4C2B08',
        cancelButtonColor: '#BF7E46',
        confirmButtonText: 'Sí, borrarla',
        cancelButtonText: 'Cancelar',
        background: '#FFF9F0',
        color: '#4C2B08',
        borderRadius: '25px',
        fontFamily: 'Plus Jakarta Sans'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'eliminar_resena.php?id=' + idResena + '&id_p=' + idProducto;
        }
    })
}

const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('msg') === 'borrado') {
    Swal.fire({
        icon: 'success',
        title: '¡Eliminada!',
        text: 'La reseña ha sido borrada correctamente.',
        showConfirmButton: false,
        timer: 2000,
        background: '#FFF9F0',
        color: '#4C2B08',
        borderRadius: '25px'
    });
}
</script>

</body>
</html>
            