<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Clientes | Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --sky: #D0E3FF;
            --espresso: #4C2B08;
            --caramel: #BF7E46;
            --milky: #FFF9F0;
            --shadow-warm: rgba(76, 43, 8, 0.11);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--sky);
            background-image:
                radial-gradient(ellipse at 10% 20%, rgba(191,126,70,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 90% 80%, rgba(76,43,8,0.05) 0%, transparent 50%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            padding: 40px 24px 60px;
            color: var(--espresso);
        }

        /* ── TOP NAV ── */
        .topbar {
            max-width: 1150px;
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
            letter-spacing: 0.02em;
        }

        .btn-volver:hover {
            background: var(--espresso);
            color: white;
            transform: translateY(-2px);
        }

        .page-title {
            font-family: 'Pacifico', cursive;
            color: var(--espresso);
            font-size: 1.4rem;
        }

        /* ── CONTAINER ── */
        .container {
            max-width: 1150px;
            margin: 0 auto;
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── HEADER PANEL ── */
        .panel-header {
            background: var(--espresso);
            border-radius: 28px 28px 0 0;
            padding: 28px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }

        .panel-header::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(191,126,70,0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .panel-header-left { position: relative; z-index: 1; }

        .panel-eyebrow {
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

        .panel-eyebrow::before {
            content: '';
            display: inline-block;
            width: 18px; height: 2px;
            background: var(--caramel);
            border-radius: 2px;
        }

        .panel-header h2 {
            font-family: 'Pacifico', cursive;
            color: #fff;
            font-size: 1.7rem;
            line-height: 1.2;
        }

        .panel-header p {
            color: rgba(255,255,255,0.4);
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 4px;
        }

        .total-badge {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 14px 22px;
            text-align: center;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .total-badge .num {
            font-family: 'Pacifico', cursive;
            color: #fff;
            font-size: 2rem;
            line-height: 1;
            display: block;
        }

        .total-badge .lbl {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--caramel);
            margin-top: 4px;
            display: block;
        }

        /* ── TABLE WRAPPER ── */
        .table-wrap {
            background: var(--milky);
            border-radius: 0 0 28px 28px;
            box-shadow: 0 20px 50px var(--shadow-warm);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: white;
        }

        th {
            padding: 16px 20px;
            font-size: 0.66rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.13em;
            color: var(--caramel);
            text-align: left;
            border-bottom: 2px solid rgba(76,43,8,0.06);
        }

        td {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(76,43,8,0.05);
            font-size: 0.88rem;
            color: var(--espresso);
            font-weight: 600;
            vertical-align: middle;
        }

        tbody tr {
            transition: background 0.18s;
        }

        tbody tr:hover { background: rgba(191,126,70,0.04); }
        tbody tr:last-child td { border-bottom: none; }

        /* ── CLIENT CELL ── */
        .client-cell {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .avatar {
            width: 42px; height: 42px;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--caramel), var(--espresso));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .client-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--espresso);
            display: block;
        }

        .client-email {
            font-size: 0.75rem;
            color: #b09070;
            font-weight: 500;
            margin-top: 2px;
            display: block;
        }

        /* ── WHATSAPP BTN ── */
        .ws-btn {
            text-decoration: none;
            background: #25D366;
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.22s;
            letter-spacing: 0.04em;
        }

        .ws-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37,211,102,0.3);
        }

        /* ── PUNTOS ── */
        .puntos-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .badge-puntos {
            background: var(--espresso);
            color: white;
            padding: 6px 13px;
            border-radius: 11px;
            font-weight: 800;
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .vip-tag {
            background: linear-gradient(135deg, var(--caramel), #d9943a);
            color: white;
            font-size: 0.62rem;
            padding: 3px 9px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
        }

        /* ── DATE ── */
        .date-cell {
            font-size: 0.8rem;
            color: #b09070;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ── ACTIONS ── */
        .acciones {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-action {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.88rem;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            background: none;
        }

        .btn-edit {
            color: var(--caramel);
            background: rgba(191,126,70,0.1);
        }

        .btn-edit:hover {
            background: var(--caramel);
            color: white;
            transform: translateY(-2px);
        }

        .btn-del {
            color: #d63031;
            background: rgba(214,48,49,0.08);
        }

        .btn-del:hover {
            background: #d63031;
            color: white;
            transform: translateY(-2px);
        }

        /* ── EMPTY ── */
        .empty-row td {
            text-align: center;
            padding: 50px 20px;
            color: #b09070;
            font-weight: 600;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            body { padding: 20px 12px 40px; }
            .panel-header { flex-direction: column; align-items: flex-start; gap: 16px; padding: 24px 22px; }
            th, td { padding: 14px 12px; }
            .total-badge { align-self: flex-start; }
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <a href="admin.php" class="btn-volver">
        <i class="fa-solid fa-arrow-left"></i> Volver al Panel
    </a>
    <span class="page-title">Cinnamoon</span>
</div>

<div class="container">

    <!-- HEADER -->
    <div class="panel-header">
        <div class="panel-header-left">
            <div class="panel-eyebrow">Cinamoon · Admin</div>
            <h2><i class="fa-solid fa-gem" style="font-size:1.3rem; margin-right:8px; opacity:0.8;"></i>Comunidad Cinnamoon</h2>
            <p>Clientes ordenados por puntos acumulados en sus compras.</p>
        </div>
        <?php
        $res = mysqli_query($conexion, "SELECT * FROM clientes ORDER BY puntos DESC");
        $total_clientes = mysqli_num_rows($res);
        ?>
        <div class="total-badge">
            <span class="num"><?php echo $total_clientes; ?></span>
            <span class="lbl">Clientes</span>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Mensaje de Bienvenida</th>
                    <th>Puntos Acumulados</th>
                    <th>Último Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($total_clientes > 0):
                    mysqli_data_seek($res, 0);
                    while ($c = mysqli_fetch_assoc($res)):
                        $nombre = htmlspecialchars($c['nombre']);
                        $iniciales = strtoupper(mb_substr($c['nombre'], 0, 2));
                        $msg = "¡Hola $nombre! ✨ Bienvenido a la familia Cinnamoon 🥮. Ya eres parte de nuestro club VIP. Recuerda que acumulaste {$c['puntos']} puntos en tu visita. ¡Sigue endulzando tus días con nosotros! 💫☕";
                        $link_ws = "https://wa.me/" . $c['telefono'] . "?text=" . urlencode($msg);
                ?>
                <tr>
                    <td>
                        <div class="client-cell">
                            <div class="avatar"><?php echo $iniciales; ?></div>
                            <div>
                                <span class="client-name"><?php echo $nombre; ?></span>
                                <span class="client-email"><?php echo htmlspecialchars($c['email']); ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="<?php echo $link_ws; ?>" target="_blank" class="ws-btn">
                            <i class="fa-brands fa-whatsapp"></i> Bienvenida
                        </a>
                    </td>
                    <td>
                        <div class="puntos-container">
                            <span class="badge-puntos">
                                <i class="fa-solid fa-star" style="color:#FFD700;"></i>
                                <?php echo $c['puntos']; ?> pts
                            </span>
                            <?php if ($c['puntos'] >= 100): ?>
                                <span class="vip-tag">⭐ Cliente Oro</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <span class="date-cell">
                            <i class="fa-regular fa-calendar"></i>
                            <?php echo date('d/m/Y', strtotime($c['fecha_registro'])); ?>
                        </span>
                    </td>
                    <td>
                        <div class="acciones">
                            <a href="editar_cliente.php?id=<?php echo $c['id']; ?>" class="btn-action btn-edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="eliminar_cliente.php?id=<?php echo $c['id']; ?>" class="btn-action btn-del" onclick="return confirm('¿Eliminar cliente?')">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr class="empty-row">
                    <td colspan="5">
                        <i class="fa-regular fa-face-smile" style="font-size:1.5rem; display:block; margin-bottom:8px; color:var(--caramel);"></i>
                        Aún no hay clientes registrados.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>