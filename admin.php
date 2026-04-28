<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: index.php"); exit(); }
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo | Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --sky: #D0E3FF;
            --espresso: #4C2B08;
            --caramel: #BF7E46;
            --milky: #FFF9F0;
            --caramel-soft: rgba(191,126,70,0.1);
            --espresso-soft: rgba(76,43,8,0.06);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f4fb;
            color: var(--espresso);
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 240px;
            height: 100vh;
            background: var(--espresso);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            bottom: -60px; right: -60px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(191,126,70,0.2) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            top: -40px; left: -40px;
            width: 160px; height: 160px;
            background: radial-gradient(circle, rgba(191,126,70,0.15) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 28px 24px 22px;
            border-bottom: 1px solid rgba(191,126,70,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .sidebar-logo {
            width: 38px; height: 38px;
            border-radius: 12px;
            background: rgba(255,249,240,0.08);
            border: 1px solid rgba(191,126,70,0.3);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }

        .sidebar-logo img { width: 26px; }

        .sidebar-brand-name {
            font-family: 'Pacifico', cursive;
            color: #FFF9F0;
            font-size: 1.25rem;
        }

        .sidebar-user {
            padding: 18px 24px;
            border-bottom: 1px solid rgba(191,126,70,0.12);
            position: relative;
            z-index: 2;
        }

        .user-avatar {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--caramel), #d4974f);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800;
            font-size: 15px;
            color: white;
            margin-bottom: 10px;
        }

        .user-name {
            font-size: 13px;
            font-weight: 700;
            color: #FFF9F0;
            margin-bottom: 3px;
        }

        .user-role {
            font-size: 11px;
            color: rgba(255,249,240,0.4);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            position: relative;
            z-index: 2;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,249,240,0.25);
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 10px 10px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            color: rgba(255,249,240,0.55);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 13px;
        }

        .nav-item:hover {
            background: rgba(191,126,70,0.15);
            color: #FFF9F0;
        }

        .nav-item.active {
            background: var(--caramel);
            color: white;
            box-shadow: 0 4px 14px rgba(191,126,70,0.4);
        }

        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid rgba(191,126,70,0.12);
            position: relative;
            z-index: 2;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 11px 14px;
            border-radius: 12px;
            background: rgba(191,126,70,0.12);
            border: none;
            color: rgba(255,249,240,0.6);
            font-size: 13px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: rgba(191,126,70,0.25);
            color: #FFF9F0;
        }

        /* ── MAIN CONTENT ── */
        .main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: white;
            padding: 0 40px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(76,43,8,0.07);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left h2 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--espresso);
            letter-spacing: -0.3px;
        }

        .topbar-left p {
            font-size: 12px;
            color: var(--espresso);
            opacity: 0.4;
            font-weight: 500;
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-store-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 12px;
            background: var(--espresso-soft);
            color: var(--espresso);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            border: 1.5px solid rgba(76,43,8,0.08);
            transition: 0.2s;
        }

        .topbar-store-btn:hover {
            background: var(--caramel-soft);
            border-color: rgba(191,126,70,0.2);
            color: var(--caramel);
        }

        /* ── PAGE BODY ── */
        .page-body {
            padding: 40px;
            flex: 1;
        }

        /* ── WELCOME STRIP ── */
        .welcome-strip {
            background: var(--espresso);
            border-radius: 22px;
            padding: 32px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 36px;
            position: relative;
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }

        .welcome-strip::before {
            content: '';
            position: absolute;
            right: -60px; top: -60px;
            width: 240px; height: 240px;
            background: radial-gradient(circle, rgba(191,126,70,0.25) 0%, transparent 65%);
            border-radius: 50%;
        }

        .welcome-strip::after {
            content: '';
            position: absolute;
            left: 40%; bottom: -80px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(208,227,255,0.08) 0%, transparent 65%);
            border-radius: 50%;
        }

        .welcome-text { position: relative; z-index: 2; }

        .welcome-text h1 {
            font-size: 1.9rem;
            font-weight: 800;
            color: #FFF9F0;
            letter-spacing: -0.6px;
            margin-bottom: 6px;
        }

        .welcome-text h1 span { color: var(--caramel); }

        .welcome-text p {
            font-size: 13px;
            color: rgba(255,249,240,0.45);
            font-weight: 500;
        }

        .welcome-badge {
            position: relative;
            z-index: 2;
            background: rgba(191,126,70,0.2);
            border: 1px solid rgba(191,126,70,0.3);
            border-radius: 16px;
            padding: 14px 20px;
            text-align: center;
        }

        .welcome-badge-emoji { font-size: 2rem; display: block; margin-bottom: 4px; }
        .welcome-badge-label { font-size: 11px; color: rgba(255,249,240,0.5); font-weight: 700; letter-spacing: 0.5px; }

        /* ── SECTION LABEL ── */
        .section-label {
            font-size: 11.5px;
            font-weight: 800;
            color: var(--espresso);
            opacity: 0.35;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 18px;
            animation: fadeUp 0.5s 0.1s ease both;
        }

        /* ── CARDS GRID ── */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 22px;
        }

        .box {
            background: white;
            border-radius: 22px;
            padding: 30px;
            border: 1.5px solid rgba(76,43,8,0.06);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s, border-color 0.3s;
            position: relative;
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }

        .box:nth-child(1) { animation-delay: 0.15s; }
        .box:nth-child(2) { animation-delay: 0.22s; }
        .box:nth-child(3) { animation-delay: 0.29s; }
        .box:nth-child(4) { animation-delay: 0.36s; }

        .box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--caramel), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .box:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(76,43,8,0.1);
            border-color: rgba(191,126,70,0.2);
        }

        .box:hover::before { opacity: 1; }

        .box-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
        }

        .icon-espresso { background: rgba(76,43,8,0.08); }
        .icon-caramel  { background: rgba(191,126,70,0.12); }
        .icon-sky      { background: rgba(208,227,255,0.7); }
        .icon-mint     { background: rgba(100,190,150,0.12); }

        .box h2 {
            font-family: 'Pacifico', cursive;
            color: var(--espresso);
            font-size: 1.35rem;
            margin-bottom: 10px;
        }

        .box p {
            color: var(--espresso);
            opacity: 0.5;
            font-size: 13px;
            line-height: 1.65;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .box-actions { display: flex; gap: 10px; align-items: center; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            font-family: inherit;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-espresso {
            background: var(--espresso);
            color: white;
        }
        .btn-espresso:hover {
            background: #3a1f05;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(76,43,8,0.25);
        }

        .btn-caramel {
            background: var(--caramel);
            color: white;
        }
        .btn-caramel:hover {
            background: #a86c38;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(191,126,70,0.35);
        }

        .btn-outline {
            background: rgba(76,43,8,0.05);
            border: 1.5px solid rgba(76,43,8,0.1);
            color: var(--espresso);
            padding: 11px 14px;
        }
        .btn-outline:hover {
            background: rgba(191,126,70,0.1);
            border-color: rgba(191,126,70,0.25);
            color: var(--caramel);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .sidebar { width: 200px; }
            .main { margin-left: 200px; }
            .page-body { padding: 24px; }
            .topbar { padding: 0 24px; }
        }

        @media (max-width: 700px) {
            .sidebar { display: none; }
            .main { margin-left: 0; }
            .welcome-strip { flex-direction: column; gap: 16px; }
        }
    </style>
</head>
<body>

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo">
                <img src="IMALOGO-removebg-preview.png" alt="Logo">
            </div>
            <span class="sidebar-brand-name">Cinnamoon</span>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar"><?php echo strtoupper(substr($nombre, 0, 1)); ?></div>
            <div class="user-name"><?php echo htmlspecialchars($nombre); ?></div>
            <div class="user-role"><?php echo htmlspecialchars($rol); ?></div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menú</div>
            <a href="admin.php" class="nav-item active">
                <i class="fa-solid fa-house"></i> Inicio
            </a>
            <a href="ver_pedidos.php" class="nav-item">
                <i class="fa-solid fa-box"></i> Pedidos
            </a>
            <a href="ver_inventario.php" class="nav-item">
                <i class="fa-solid fa-chart-bar"></i> Inventario
            </a>
            <?php if ($rol == 'admin'): ?>
            <div class="nav-label">Administración</div>
            <a href="ver_clientes.php" class="nav-item">
                <i class="fa-solid fa-crown"></i> Clientes
            </a>
            <a href="ver_cuentas.php" class="nav-item">
                <i class="fa-solid fa-users"></i> Personal
            </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar Sesión
            </a>
        </div>
    </aside>

    <!-- ── MAIN ── -->
    <div class="main">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <h2>Panel de Control</h2>
                <p>Gestión de Dulzura · Cinnamoon</p>
            </div>
            <div class="topbar-right">
                <a href="home.php" class="topbar-store-btn">
                    <i class="fa-solid fa-shop"></i> Ver Tienda
                </a>
            </div>
        </header>

        <!-- Body -->
        <div class="page-body">

            <!-- Welcome Strip -->
            <div class="welcome-strip">
                <div class="welcome-text">
                    <h1>Bienvenido, <span><?php echo htmlspecialchars($nombre); ?></span> 👋</h1>
                    <p>Panel de Control Administrativo · Gestión de Dulzura.</p>
                </div>
                <div class="welcome-badge">
                    <span class="welcome-badge-emoji">🧁</span>
                    <span class="welcome-badge-label"><?php echo htmlspecialchars($rol); ?></span>
                </div>
            </div>

            <!-- Cards -->
            <div class="section-label">Módulos del sistema</div>

            <div class="grid">

                <div class="box">
                    <div class="box-icon icon-espresso">📦</div>
                    <h2>Pedidos</h2>
                    <p>Gestionar compras entrantes, estados de entrega y facturación del público.</p>
                    <div class="box-actions">
                        <a href="ver_pedidos.php" class="btn btn-espresso">
                            Ver Pedidos <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="box">
                    <div class="box-icon icon-caramel">📊</div>
                    <h2>Inventario</h2>
                    <p>Control total de existencias, actualización de stock y nuevos productos.</p>
                    <div class="box-actions">
                        <a href="ver_inventario.php" class="btn btn-caramel">
                            Gestionar Stock <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <?php if ($rol == 'admin'): ?>

                <div class="box">
                    <div class="box-icon icon-sky">👑</div>
                    <h2>Clientes</h2>
                    <p>Base de datos de clientes registrados y sus puntos de fidelidad.</p>
                    <div class="box-actions">
                        <a href="ver_clientes.php" class="btn btn-espresso">
                            Ver Clientes <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="box">
                    <div class="box-icon icon-mint">👥</div>
                    <h2>Personal</h2>
                    <p>Administrar las cuentas del equipo y los permisos de acceso al sistema.</p>
                    <div class="box-actions">
                        <a href="registro.php" class="btn btn-caramel">Crear Nuevo</a>
                        <a href="ver_cuentas.php" class="btn btn-outline">
                            <i class="fa-solid fa-gear"></i>
                        </a>
                    </div>
                </div>

                <?php endif; ?>

            </div>
        </div>
    </div>

</body>
</html>