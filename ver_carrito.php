<?php
session_start();
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito | Cinnamoon</title>
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
            --red: #d63031;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body { 
            background: var(--warm-white);
            font-family: 'DM Sans', sans-serif; 
            color: var(--espresso);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background decoration */
        body::before {
            content: '';
            position: fixed;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(208,227,255,0.55) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -150px; left: -150px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(191,126,70,0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── TOP NAV BAR ── */
        .top-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 68px;
            background: rgba(255,252,247,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(191,126,70,0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            z-index: 100;
        }
        .top-bar-brand {
            font-family: 'Pacifico', cursive;
            font-size: 1.6rem;
            color: var(--espresso);
            text-decoration: none;
        }
        .top-bar-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--espresso);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: color 0.25s;
            padding: 10px 18px;
            border-radius: 12px;
            border: 1px solid rgba(191,126,70,0.2);
        }
        .top-bar-back:hover {
            color: var(--caramel);
            border-color: var(--caramel);
            background: rgba(191,126,70,0.05);
        }
        .top-bar-back i { font-size: 12px; }

        /* ── MAIN LAYOUT ── */
        .page-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 980px;
            margin-top: 88px;
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 28px;
            align-items: start;
        }

        /* ── PANEL BASE ── */
        .panel {
            background: var(--milky);
            border-radius: 32px;
            border: 1px solid rgba(191,126,70,0.12);
            overflow: hidden;
        }

        /* ── PANEL HEADER ── */
        .panel-header {
            padding: 32px 36px 24px;
            border-bottom: 1px solid rgba(191,126,70,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .panel-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--espresso);
        }
        .panel-title em {
            font-style: italic;
            color: var(--caramel);
        }
        .item-count {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #aaa;
        }

        /* ── ITEMS LIST ── */
        .items-list {
            padding: 12px 0;
        }

        .item {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 18px 36px;
            border-bottom: 1px solid rgba(76,43,8,0.05);
            transition: background 0.25s;
        }
        .item:last-child { border-bottom: none; }
        .item:hover { background: rgba(191,126,70,0.04); }

        .item-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            color: rgba(76,43,8,0.2);
            font-weight: 600;
            width: 22px;
            flex-shrink: 0;
        }

        .item img { 
            width: 72px; 
            height: 72px; 
            border-radius: 18px; 
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 6px 18px rgba(76,43,8,0.08);
        }

        .item-info { flex: 1; min-width: 0; }
        .item-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--espresso);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .item-qty-price {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .item-qty {
            font-size: 12px;
            font-weight: 700;
            color: #aaa;
            background: rgba(76,43,8,0.05);
            padding: 3px 10px;
            border-radius: 20px;
        }
        .item-unit-price {
            font-size: 12px;
            color: #bbb;
        }

        .item-subtotal {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--espresso);
            flex-shrink: 0;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            padding: 80px 40px;
            text-align: center;
        }
        .empty-icon {
            width: 90px; height: 90px;
            background: rgba(191,126,70,0.1);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            font-size: 2.2rem;
            color: var(--caramel);
            opacity: 0.7;
        }
        .empty-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--espresso);
            margin-bottom: 10px;
        }
        .empty-sub {
            color: #aaa;
            font-size: 0.95rem;
            margin-bottom: 32px;
        }
        .btn-ver-menu {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            background: var(--espresso);
            color: white;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s;
            letter-spacing: 0.03em;
        }
        .btn-ver-menu:hover { background: var(--caramel); transform: translateY(-2px); }

        /* ── SUMMARY PANEL ── */
        .summary-panel {
            background: var(--milky);
            border-radius: 32px;
            border: 1px solid rgba(191,126,70,0.12);
            padding: 32px 30px;
            position: sticky;
            top: 88px;
        }

        .summary-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 24px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            font-size: 14px;
            color: #888;
            border-bottom: 1px solid rgba(76,43,8,0.05);
        }
        .summary-row:last-of-type { border-bottom: none; }
        .summary-row span:last-child { font-weight: 600; color: var(--espresso); }

        .summary-divider {
            height: 1px;
            background: rgba(191,126,70,0.15);
            margin: 18px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 28px;
        }
        .summary-total-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--espresso);
            letter-spacing: 0.04em;
        }
        .summary-total-amount {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--espresso);
            line-height: 1;
        }

        .btn-pay { 
            width: 100%;
            background: var(--espresso); 
            color: white; 
            border: none; 
            padding: 17px; 
            border-radius: 18px; 
            font-weight: 700; 
            cursor: pointer; 
            font-size: 14px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .btn-pay:hover { 
            background: var(--caramel);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76,43,8,0.2);
        }

        .btn-empty { 
            width: 100%;
            background: transparent; 
            color: #bbb; 
            border: 1.5px solid rgba(76,43,8,0.1); 
            padding: 13px; 
            border-radius: 16px; 
            text-decoration: none; 
            text-align: center; 
            font-size: 12px; 
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: all 0.3s;
            display: block;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-empty:hover {
            color: var(--red);
            border-color: rgba(214,48,49,0.3);
            background: rgba(214,48,49,0.04);
        }

        .guarantee-note {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 22px;
            padding: 14px;
            background: rgba(191,126,70,0.07);
            border-radius: 14px;
        }
        .guarantee-note i { color: var(--caramel); font-size: 14px; flex-shrink: 0; }
        .guarantee-note span { font-size: 11px; color: #888; line-height: 1.5; }

        /* ── RESPONSIVE ── */
        @media (max-width: 750px) {
            .page-wrap {
                grid-template-columns: 1fr;
                margin-top: 80px;
            }
            .top-bar { padding: 0 24px; }
            .item { padding: 16px 20px; }
            .panel-header { padding: 24px 20px 18px; }
            .summary-panel { position: static; }
        }
    </style>
</head>
<body>

    <!-- TOP BAR -->
    <div class="top-bar">
        <a href="home.php" class="top-bar-brand">Cinnamoon</a>
        <a href="home.php" class="top-bar-back"><i class="fa-solid fa-arrow-left"></i> Seguir comprando</a>
    </div>

    <div class="page-wrap">

        <!-- ITEMS PANEL -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Mi <em>Bolsa</em></div>
                <span class="item-count">
                    <?php echo count($carrito); ?> <?php echo count($carrito) === 1 ? 'producto' : 'productos'; ?>
                </span>
            </div>

            <?php if (empty($carrito)): ?>
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-cookie-bite"></i></div>
                    <div class="empty-title">Tu bolsa está vacía</div>
                    <p class="empty-sub">Aún no has añadido nada.<br>¡Ve al menú y elige tus favoritos!</p>
                    <a href="home.php" class="btn-ver-menu"><i class="fa-solid fa-store"></i> Ver Menú</a>
                </div>

            <?php else: ?>
                <div class="items-list">
                    <?php $i = 1; foreach ($carrito as $item): 
                        $cant = $item['cantidad'] ?? 1;
                        $subtotal = $item['precio'] * $cant;
                        $total += $subtotal;
                    ?>
                        <div class="item">
                            <span class="item-num"><?php echo $i++; ?></span>
                            <img src="<?php echo $item['imagen']; ?>" alt="Producto">
                            <div class="item-info">
                                <div class="item-name"><?php echo $item['nombre']; ?></div>
                                <div class="item-qty-price">
                                    <span class="item-qty">× <?php echo $cant; ?></span>
                                    <span class="item-unit-price">RD$ <?php echo number_format($item['precio'], 0); ?> c/u</span>
                                </div>
                            </div>
                            <span class="item-subtotal">RD$ <?php echo number_format($subtotal, 0); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- SUMMARY PANEL -->
        <?php if (!empty($carrito)): ?>
        <div class="summary-panel">
            <div class="summary-label">· Resumen del pedido ·</div>

            <?php $i = 1; foreach ($carrito as $item): 
                $cant = $item['cantidad'] ?? 1;
            ?>
                <div class="summary-row">
                    <span><?php echo htmlspecialchars(substr($item['nombre'], 0, 22)); ?><?php echo strlen($item['nombre']) > 22 ? '…' : ''; ?> ×<?php echo $cant; ?></span>
                    <span>RD$ <?php echo number_format($item['precio'] * $cant, 0); ?></span>
                </div>
            <?php endforeach; ?>

            <div class="summary-divider"></div>

            <div class="summary-total">
                <span class="summary-total-label">Total</span>
                <span class="summary-total-amount">RD$ <?php echo number_format($total, 0); ?></span>
            </div>

            <button onclick="finalizarCompra()" class="btn-pay">
                <i class="fa-solid fa-check"></i> Confirmar Pedido
            </button>
            <a href="vaciar_carrito.php" class="btn-empty">Vaciar carrito</a>

            <div class="guarantee-note">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Tu pedido va directo a nuestra cocina. Hecho fresco para ti.</span>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function finalizarCompra() {
            Swal.fire({
                title: '¿Confirmar Pedido?',
                text: "Tu orden será enviada directamente a nuestra cocina.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4C2B08',
                cancelButtonColor: '#aaa',
                confirmButtonText: '¡Sí, pedir!',
                cancelButtonText: 'Revisar más',
                background: '#FFF9F0',
                color: '#4C2B08'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'finalizar_compra.php';
                }
            });
        }
    </script>
</body>
</html>