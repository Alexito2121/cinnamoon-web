<?php
session_start();
include 'conexion.php';

$rol = $_SESSION['rol'] ?? '';
if ($rol !== 'admin' && $rol !== 'empleado') {
    header("Location: index.php");
    exit();
}

// --- LÓGICA PARA DESPACHAR PEDIDO ---
if (isset($_GET['despachar_id'])) {
    $id_v = (int)$_GET['despachar_id'];
    mysqli_query($conexion, "UPDATE ventas SET estado = 'Completado' WHERE id = $id_v");
    echo "<script>
        window.open('generar_ticket.php?id=$id_v', '_blank');
        window.location.href = 'ver_pedidos.php'; 
    </script>";
}

$res = mysqli_query($conexion, "SELECT * FROM ventas ORDER BY fecha DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos | Cinnamoon</title>
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
            letter-spacing: -.2px;
        }

        .table-card-header span {
            font-size: 11.5px;
            color: var(--espresso);
            opacity: .38;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: #faf8f5;
        }

        th {
            text-align: left;
            padding: 13px 20px;
            color: var(--espresso);
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
            opacity: .45;
            border-bottom: 1px solid rgba(76,43,8,0.06);
            white-space: nowrap;
        }

        td {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(76,43,8,0.04);
            font-size: 13.5px;
            vertical-align: middle;
        }

        tbody tr {
            transition: background .15s;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr:hover { background: #fdfcfa; }

        /* ticket number */
        .ticket-num {
            font-size: 13px;
            font-weight: 800;
            color: var(--espresso);
            opacity: .55;
        }

        /* user tag */
        .user-tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(208,227,255,0.5);
            border: 1px solid rgba(76,43,8,0.08);
            padding: 5px 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 12.5px;
            color: var(--espresso);
        }

        .user-tag i { opacity: .5; font-size: 11px; }

        /* price */
        .price {
            font-weight: 800;
            font-size: 14px;
            color: var(--caramel);
        }

        /* date */
        .date-cell {
            font-size: 12.5px;
            color: var(--espresso);
            opacity: .45;
            font-weight: 500;
        }

        /* status badges */
        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: .5px;
            white-space: nowrap;
        }

        .status::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-pendiente {
            background: #fff8ec;
            color: #b8820e;
            border: 1px solid #ffe8b0;
        }

        .status-pendiente::before { background: #d4a017; }

        .status-completado {
            background: #edfaf2;
            color: #1a8c4e;
            border: 1px solid #b6eacf;
        }

        .status-completado::before { background: #2ecc71; }

        /* action buttons */
        .actions { display: flex; gap: 8px; align-items: center; }

        .btn-ver {
            background: rgba(208,227,255,0.6);
            color: var(--espresso);
            padding: 7px 13px;
            border-radius: 10px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid rgba(76,43,8,0.08);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: .2s;
            font-family: inherit;
        }

        .btn-ver:hover {
            background: rgba(208,227,255,0.9);
            transform: translateY(-1px);
        }

        .btn-despachar {
            background: var(--espresso);
            color: white;
            text-decoration: none;
            padding: 7px 13px;
            border-radius: 10px;
            font-size: 11.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: .2s;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-despachar:hover {
            background: var(--caramel);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(191,126,70,0.3);
        }

        .btn-reimprimir {
            background: white;
            color: var(--espresso);
            border: 1.5px solid rgba(76,43,8,0.1);
            text-decoration: none;
            padding: 7px 13px;
            border-radius: 10px;
            font-size: 11.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: .2s;
        }

        .btn-reimprimir:hover {
            border-color: rgba(191,126,70,0.25);
            color: var(--caramel);
            background: rgba(191,126,70,0.05);
        }

        /* ── MODAL ── */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(76,43,8,0.35);
            backdrop-filter: blur(6px);
            align-items: center;
            justify-content: center;
        }

        .modal.open { display: flex; }

        .modal-content {
            background: white;
            border-radius: 24px;
            width: 460px;
            max-width: 94vw;
            box-shadow: 0 30px 80px rgba(76,43,8,0.18);
            overflow: hidden;
            animation: scaleIn .25s cubic-bezier(.175,.885,.32,1.275) both;
        }

        .modal-header {
            background: var(--espresso);
            padding: 22px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            right: -30px; top: -30px;
            width: 120px; height: 120px;
            background: radial-gradient(circle, rgba(191,126,70,0.25) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        .modal-header h3 {
            font-size: 1rem;
            font-weight: 800;
            color: #FFF9F0;
            position: relative;
            z-index: 2;
        }

        .close-btn {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: rgba(255,249,240,0.1);
            border: 1px solid rgba(255,249,240,0.15);
            color: rgba(255,249,240,0.7);
            font-size: 15px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: .2s;
            position: relative;
            z-index: 2;
        }

        .close-btn:hover {
            background: rgba(255,249,240,0.2);
            color: #FFF9F0;
        }

        .modal-body {
            padding: 24px 26px;
        }

        #contenidoOrden { margin-bottom: 0; }

        .modal-footer {
            padding: 0 26px 22px;
        }

        .btn-cerrar {
            width: 100%;
            background: #faf8f5;
            border: 1.5px solid rgba(76,43,8,0.08);
            padding: 12px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            color: var(--espresso);
            font-family: inherit;
            transition: .2s;
        }

        .btn-cerrar:hover {
            background: rgba(191,126,70,0.08);
            border-color: rgba(191,126,70,0.2);
            color: var(--caramel);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(.93); }
            to   { opacity: 1; transform: scale(1); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 700px) {
            body { padding: 20px 16px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 14px; }
            th, td { padding: 11px 14px; }
        }
    </style>
</head>
<body>

    <!-- PAGE HEADER -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">🧾</div>
            <div class="page-title">
                <h1>Historial de Ventas</h1>
                <p>Gestión y despacho de pedidos · Cinnamoon</p>
            </div>
        </div>
        <a href="admin.php" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <!-- TABLE CARD -->
    <div class="table-card">
        <div class="table-card-header">
            <h2><i class="fa-solid fa-receipt" style="margin-right:8px; opacity:.5;"></i>Todos los pedidos</h2>
            <span>Ordenados por fecha reciente</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Cliente</th>
                    <th>Monto Total</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($p = mysqli_fetch_assoc($res)):
                    $est = strtolower($p['estado']);
                    $clase_estado = ($est == 'completado') ? 'status-completado' : 'status-pendiente';
                ?>
                <tr>
                    <td><span class="ticket-num">#<?php echo $p['id']; ?></span></td>
                    <td>
                        <span class="user-tag">
                            <i class="fa-solid fa-user"></i>
                            <?php echo htmlspecialchars($p['usuario']); ?>
                        </span>
                    </td>
                    <td><span class="price">RD$ <?php echo number_format($p['total'], 0); ?></span></td>
                    <td><span class="date-cell"><?php echo date('d/m/Y H:i', strtotime($p['fecha'])); ?></span></td>
                    <td><span class="status <?php echo $clase_estado; ?>"><?php echo $p['estado']; ?></span></td>
                    <td class="actions">
                        <button class="btn-ver" onclick="verOrden(<?php echo $p['id']; ?>, '<?php echo $p['usuario']; ?>')">
                            <i class="fa-solid fa-eye"></i> Ver
                        </button>
                        <?php if($est !== 'completado'): ?>
                            <a href="ver_pedidos.php?despachar_id=<?php echo $p['id']; ?>" class="btn-despachar" onclick="return confirm('¿Marcar como entregado?')">
                                <i class="fa-solid fa-check"></i> Despachar
                            </a>
                        <?php else: ?>
                            <a href="generar_ticket.php?id=<?php echo $p['id']; ?>" target="_blank" class="btn-reimprimir">
                                <i class="fa-solid fa-print"></i> Ticket
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- MODAL -->
    <div id="modalOrden" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitulo">Detalle de Orden</h3>
                <button class="close-btn" onclick="cerrarModal()">✕</button>
            </div>
            <div class="modal-body">
                <div id="contenidoOrden"></div>
            </div>
            <div class="modal-footer">
                <button onclick="cerrarModal()" class="btn-cerrar">Cerrar Vista</button>
            </div>
        </div>
    </div>

    <script>
        function verOrden(id, cliente) {
            document.getElementById('modalOrden').classList.add('open');
            document.getElementById('modalTitulo').innerText = 'Orden #' + id + ' — ' + cliente;
            fetch('obtener_detalle.php?id=' + id)
                .then(response => response.text())
                .then(html => { document.getElementById('contenidoOrden').innerHTML = html; });
        }
        function cerrarModal() { document.getElementById('modalOrden').classList.remove('open'); }
        window.onclick = function(event) { if (event.target == document.getElementById('modalOrden')) cerrarModal(); }
    </script>

</body>
</html>