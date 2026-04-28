<?php
session_start();
include 'conexion.php';

// 1. SEGURIDAD: Solo Admin y Empleado pueden gestionar inventario
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
    <title>Inventario | Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --sky: #D0E3FF;
            --espresso: #4C2B08;
            --caramel: #BF7E46;
            --milky: #FFF9F0;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #f0f4fb;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--espresso);
            min-height: 100vh;
            padding: 36px 40px;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            animation: fadeUp .45s ease both;
        }

        .page-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-icon {
            width: 50px; height: 50px;
            background: var(--espresso);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            box-shadow: 0 6px 18px rgba(76,43,8,0.25);
            flex-shrink: 0;
        }

        .page-title h1 {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--espresso);
            letter-spacing: -.5px;
        }

        .page-title p {
            font-size: 12.5px;
            color: var(--espresso);
            opacity: .42;
            font-weight: 500;
            margin-top: 2px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 12px;
            background: white;
            border: 1.5px solid rgba(76,43,8,0.09);
            color: var(--espresso);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .back-btn:hover {
            background: rgba(191,126,70,0.08);
            border-color: rgba(191,126,70,0.2);
            color: var(--caramel);
        }

        /* ── TABLE CARD ── */
        .table-card {
            background: white;
            border-radius: 22px;
            border: 1.5px solid rgba(76,43,8,0.06);
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(76,43,8,0.06);
            animation: fadeUp .45s .1s ease both;
        }

        .table-card-header {
            padding: 20px 28px;
            border-bottom: 1px solid rgba(76,43,8,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-card-header h2 {
            font-size: 14px;
            font-weight: 800;
            color: var(--espresso);
        }

        .table-card-header span {
            font-size: 11.5px;
            color: var(--espresso);
            opacity: .35;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr { background: #faf8f5; }

        th {
            text-align: left;
            padding: 13px 20px;
            color: var(--espresso);
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
            opacity: .42;
            border-bottom: 1px solid rgba(76,43,8,0.06);
            white-space: nowrap;
        }

        td {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(76,43,8,0.04);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fdfcfa; }
        tbody tr { transition: background .15s; }

        /* product image */
        .img-mini {
            width: 50px; height: 50px;
            object-fit: cover;
            border-radius: 14px;
            border: 1.5px solid rgba(76,43,8,0.08);
            display: block;
        }

        /* product name */
        .prod-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--espresso);
        }

        /* stock number */
        .stock-normal {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--espresso);
        }

        .stock-alert {
            font-size: 13.5px;
            font-weight: 800;
            color: #c0392b;
        }

        /* limit */
        .limit-cell {
            font-size: 13px;
            color: var(--espresso);
            opacity: .4;
            font-weight: 600;
        }

        /* stock bar */
        .stock-bar-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stock-bar-bg {
            flex: 1;
            height: 6px;
            background: rgba(76,43,8,0.07);
            border-radius: 99px;
            overflow: hidden;
            min-width: 60px;
        }

        .stock-bar-fill {
            height: 100%;
            border-radius: 99px;
            transition: width .5s;
        }

        /* status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 10px;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            white-space: nowrap;
        }

        .status-badge::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
        }

        .bg-danger  { background: #ffeaea; color: #c0392b; border: 1px solid #f5c6cb; }
        .bg-danger::before  { background: #d63031; }

        .bg-warning { background: #fff8ec; color: #b8820e; border: 1px solid #ffe8b0; }
        .bg-warning::before { background: #d4a017; }

        .bg-success { background: #edfaf2; color: #1a8c4e; border: 1px solid #b6eacf; }
        .bg-success::before { background: #2ecc71; }

        /* action button */
        .btn-edit-stock {
            background: var(--caramel);
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 10px;
            font-size: 11.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: .2s;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-edit-stock:hover {
            background: var(--espresso);
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(76,43,8,0.2);
        }

        /* ── ANIMATION ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body { padding: 20px 16px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 14px; }
            .img-mini { display: none; }
            .stock-bar-wrap { display: none; }
            th, td { padding: 10px 12px; }
        }
    </style>
</head>
<body>

    <!-- PAGE HEADER -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">📦</div>
            <div class="page-title">
                <h1>Inventario Dulce</h1>
                <p>Control de stock y existencias · Cinnamoon</p>
            </div>
        </div>
        <a href="admin.php" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <!-- TABLE CARD -->
    <div class="table-card">
        <div class="table-card-header">
            <h2><i class="fa-solid fa-boxes-stacked" style="margin-right:8px; opacity:.5;"></i>Productos en sistema</h2>
            <span>Ordenados por stock más bajo</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Stock Actual</th>
                    <th>Límite</th>
                    <th>Nivel</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conexion, "SELECT * FROM productos ORDER BY stock ASC");
                while($p = mysqli_fetch_assoc($res)):

                    $clase_badge  = "bg-success";
                    $texto_estado = "Disponible";
                    $alerta_visual = false;

                    if ($p['stock'] <= 0) {
                        $clase_badge  = "bg-danger";
                        $texto_estado = "Agotado";
                        $alerta_visual = true;
                    } elseif ($p['stock'] <= $p['stock_limite']) {
                        $clase_badge  = "bg-warning";
                        $texto_estado = "Comprar más";
                        $alerta_visual = true;
                    }

                    // bar color & width
                    $limite_ref = max($p['stock_limite'] * 3, 1);
                    $pct = min(100, round(($p['stock'] / $limite_ref) * 100));
                    if ($p['stock'] <= 0)                    $bar_color = '#f5c6cb';
                    elseif ($p['stock'] <= $p['stock_limite']) $bar_color = '#ffe8b0';
                    else                                       $bar_color = '#b6eacf';
                ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($p['imagen']); ?>" class="img-mini" alt="Producto">
                    </td>
                    <td>
                        <span class="prod-name"><?php echo htmlspecialchars($p['nombre']); ?></span>
                    </td>
                    <td>
                        <span class="<?php echo $alerta_visual ? 'stock-alert' : 'stock-normal'; ?>">
                            <?php echo $p['stock']; ?> uds
                        </span>
                    </td>
                    <td>
                        <span class="limit-cell"><?php echo $p['stock_limite']; ?></span>
                    </td>
                    <td>
                        <div class="stock-bar-wrap">
                            <div class="stock-bar-bg">
                                <div class="stock-bar-fill" style="width:<?php echo $pct; ?>%; background:<?php echo $bar_color; ?>;"></div>
                            </div>
                            <span style="font-size:11px; font-weight:700; color:var(--espresso); opacity:.4; min-width:30px;"><?php echo $pct; ?>%</span>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge <?php echo $clase_badge; ?>">
                            <?php echo $texto_estado; ?>
                        </span>
                    </td>
                    <td>
                        <a href="editar_producto.php?id=<?php echo $p['id']; ?>" class="btn-edit-stock">
                            <i class="fa-solid fa-pen-to-square"></i> Ajustar
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>