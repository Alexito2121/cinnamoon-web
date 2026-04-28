<?php
session_start();
include 'conexion.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ver_pedidos.php");
    exit();
}

$id_venta = (int)$_GET['id'];
$query_v = mysqli_query($conexion, "SELECT * FROM ventas WHERE id = $id_venta");
$venta = mysqli_fetch_assoc($query_v);

if (!$venta) {
    header("Location: ver_pedidos.php");
}

$query_d = mysqli_query($conexion, "SELECT * FROM detalle_ventas WHERE id_venta = $id_venta");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #<?php echo $id_venta; ?> - Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --sky: #D0E3FF;
            --espresso: #4C2B08;
            --caramel: #BF7E46;
            --milky: #FFF9F0;
            --shadow-warm: rgba(76, 43, 8, 0.12);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--sky);
            background-image:
                radial-gradient(ellipse at 15% 20%, rgba(191,126,70,0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 85% 80%, rgba(76,43,8,0.07) 0%, transparent 50%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            padding: 40px 20px 60px;
            color: var(--espresso);
        }

        /* ── TOPBAR ── */
        .topbar {
            max-width: 720px;
            margin: 0 auto 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-volver {
            text-decoration: none;
            color: var(--espresso);
            font-weight: 700;
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 9px 18px;
            border-radius: 14px;
            box-shadow: 0 4px 14px var(--shadow-warm);
            transition: all 0.22s;
        }

        .btn-volver:hover {
            background: var(--espresso);
            color: white;
            transform: translateY(-2px);
        }

        /* ── INVOICE CARD ── */
        .invoice-card {
            max-width: 720px;
            margin: 0 auto;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 24px 60px var(--shadow-warm);
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── INVOICE HEADER ── */
        .inv-header {
            background: var(--espresso);
            padding: 36px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .inv-header::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(191,126,70,0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .inv-header::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 40px;
            width: 140px; height: 140px;
            background: radial-gradient(circle, rgba(208,227,255,0.07) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .logo-box { position: relative; z-index: 1; }

        .logo-box h1 {
            font-family: 'Pacifico', cursive;
            color: #fff;
            font-size: 2.2rem;
            line-height: 1;
        }

        .logo-box .tagline {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.35);
            font-weight: 600;
            margin-top: 4px;
            letter-spacing: 0.08em;
        }

        .inv-number { text-align: right; position: relative; z-index: 1; }

        .inv-number .label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--caramel);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            margin-bottom: 4px;
        }

        .inv-number .label::after {
            content: '';
            display: inline-block;
            width: 18px; height: 2px;
            background: var(--caramel);
            border-radius: 2px;
        }

        .inv-number .num {
            font-family: 'Pacifico', cursive;
            color: #fff;
            font-size: 1.8rem;
        }

        /* ── BODY ── */
        .inv-body {
            background: var(--milky);
            padding: 40px 50px 50px;
        }

        /* ── CLIENT INFO ── */
        .client-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 36px;
        }

        .info-card {
            background: white;
            border-radius: 18px;
            padding: 18px 22px;
            border: 1px solid rgba(76,43,8,0.06);
        }

        .info-card .info-label {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.13em;
            color: var(--caramel);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-card .info-val {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--espresso);
        }

        /* ── SECTION LABEL ── */
        .section-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .section-label span {
            font-size: 0.66rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: var(--caramel);
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(76,43,8,0.08);
        }

        /* ── TABLE ── */
        .table-products {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .table-products th {
            padding: 12px 16px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.13em;
            color: var(--caramel);
            border-bottom: 2px solid rgba(76,43,8,0.08);
            background: white;
        }

        .table-products th:first-child { border-radius: 12px 0 0 0; }
        .table-products th:last-child  { border-radius: 0 12px 0 0; }

        .table-products td {
            padding: 14px 16px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--espresso);
            border-bottom: 1px solid rgba(76,43,8,0.05);
        }

        .table-products tbody tr:last-child td { border-bottom: none; }
        .table-products tbody tr:hover { background: rgba(191,126,70,0.04); }

        .table-wrap {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(76,43,8,0.06);
            margin-bottom: 28px;
        }

        .product-name { font-weight: 700; }

        .qty-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--sky);
            color: var(--espresso);
            font-weight: 800;
            font-size: 0.82rem;
            width: 32px; height: 32px;
            border-radius: 8px;
        }

        /* ── TOTAL ── */
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 36px;
        }

        .total-box {
            background: var(--espresso);
            color: white;
            padding: 22px 36px;
            border-radius: 20px;
            text-align: right;
            position: relative;
            overflow: hidden;
            min-width: 220px;
        }

        .total-box::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 100px; height: 100px;
            background: radial-gradient(circle, rgba(191,126,70,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .total-box .total-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: rgba(255,255,255,0.5);
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .total-box .total-amount {
            font-family: 'Pacifico', cursive;
            font-size: 1.9rem;
            color: #fff;
            position: relative;
            z-index: 1;
            line-height: 1;
        }

        /* ── FOOTER NOTE ── */
        .footer-note {
            text-align: center;
            padding-top: 28px;
            border-top: 2px dashed rgba(191,126,70,0.3);
        }

        .footer-note .thank-you {
            font-family: 'Pacifico', cursive;
            color: var(--caramel);
            font-size: 1.3rem;
            margin-bottom: 6px;
        }

        .footer-note small {
            font-size: 0.78rem;
            color: #b09070;
            font-weight: 500;
        }

        /* ── ACTIONS ── */
        .actions {
            max-width: 720px;
            margin: 24px auto 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 14px 32px;
            background: var(--espresso);
            color: white;
            border: none;
            border-radius: 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.88rem;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s;
            letter-spacing: 0.04em;
        }

        .btn-print:hover {
            background: var(--caramel);
            transform: translateY(-3px);
            box-shadow: 0 10px 26px rgba(191,126,70,0.35);
        }

        /* ── PRINT ── */
        @media print {
            body { background: white; padding: 0; }
            .topbar, .actions { display: none !important; }
            .invoice-card {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }
            .inv-header { border-radius: 0; }
            .inv-body { padding: 30px 40px 40px; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }

        @media (max-width: 600px) {
            .inv-header { padding: 28px 24px; flex-direction: column; align-items: flex-start; gap: 16px; }
            .inv-number { text-align: left; }
            .inv-number .label { justify-content: flex-start; }
            .inv-body { padding: 28px 22px 36px; }
            .client-info { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <a href="ver_pedidos.php" class="btn-volver">
        <i class="fa-solid fa-arrow-left"></i> Volver al Listado
    </a>
</div>

<!-- INVOICE -->
<div class="invoice-card">

    <!-- HEADER -->
    <div class="inv-header">
        <div class="logo-box">
            <h1>Cinnamoon</h1>
            <p class="tagline">Rolls · Mangonadas · Alegría</p>
        </div>
        <div class="inv-number">
            <div class="label">Comprobante</div>
            <div class="num">#<?php echo str_pad($id_venta, 5, "0", STR_PAD_LEFT); ?></div>
        </div>
    </div>

    <!-- BODY -->
    <div class="inv-body">

        <!-- CLIENT INFO -->
        <div class="client-info">
            <div class="info-card">
                <div class="info-label"><i class="fa-solid fa-user"></i> Cliente</div>
                <div class="info-val"><?php echo htmlspecialchars($venta['usuario']); ?></div>
            </div>
            <div class="info-card">
                <div class="info-label"><i class="fa-regular fa-calendar"></i> Fecha de Venta</div>
                <div class="info-val"><?php echo date("d/m/Y", strtotime($venta['fecha'])); ?></div>
            </div>
        </div>

        <!-- PRODUCTS -->
        <div class="section-label"><span>Detalle del Pedido</span></div>

        <div class="table-wrap">
            <table class="table-products">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th style="text-align:center;">Cant.</th>
                        <th style="text-align:right;">Unitario</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = mysqli_fetch_assoc($query_d)): ?>
                    <tr>
                        <td><span class="product-name"><?php echo htmlspecialchars($r['producto']); ?></span></td>
                        <td style="text-align:center;">
                            <span class="qty-badge"><?php echo $r['cantidad']; ?></span>
                        </td>
                        <td style="text-align:right;">RD$ <?php echo number_format($r['precio'], 2); ?></td>
                        <td style="text-align:right; font-weight:800;">RD$ <?php echo number_format($r['precio'] * $r['cantidad'], 2); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- TOTAL -->
        <div class="total-row">
            <div class="total-box">
                <div class="total-label">Monto Total a Pagar</div>
                <div class="total-amount">RD$ <?php echo number_format($venta['total'], 2); ?></div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer-note">
            <p class="thank-you">¡Gracias por endulzar tu día!</p>
            <small>Cinnamoon: Rolls, Mangonadas y mucha alegría.</small>
        </div>

    </div>
</div>

<!-- ACTIONS -->
<div class="actions">
    <button onclick="window.print()" class="btn-print">
        <i class="fa-solid fa-print"></i> Imprimir Ticket
    </button>
</div>

</body>
</html>