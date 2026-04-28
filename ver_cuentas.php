<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php?error=privilegios");
    exit();
}

if (isset($_POST['actualizar_datos'])) {
    $id_edit = mysqli_real_escape_string($conexion, $_POST['id_usuario']);
    $nuevo_nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $nuevo_email = mysqli_real_escape_string($conexion, $_POST['email']);
    mysqli_query($conexion, "UPDATE usuarios SET nombre = '$nuevo_nombre', email = '$nuevo_email' WHERE id = '$id_edit'");
    header("Location: ver_cuentas.php?mensaje=actualizado_ok");
    exit();
}

if (isset($_GET['cambiar_rol']) && isset($_GET['nuevo_rol'])) {
    $id_usuario = mysqli_real_escape_string($conexion, $_GET['cambiar_rol']);
    $nuevo_rol = mysqli_real_escape_string($conexion, $_GET['nuevo_rol']);
    if ($id_usuario != $_SESSION['usuario_id']) {
        mysqli_query($conexion, "UPDATE usuarios SET rol = '$nuevo_rol' WHERE id = '$id_usuario'");
        header("Location: ver_cuentas.php?mensaje=rol_actualizado");
        exit();
    }
}

if (isset($_GET['borrar'])) {
    $id_borrar = mysqli_real_escape_string($conexion, $_GET['borrar']);
    if ($id_borrar != $_SESSION['usuario_id']) {
        mysqli_query($conexion, "DELETE FROM usuarios WHERE id = '$id_borrar'");
        header("Location: ver_cuentas.php?mensaje=borrado_ok");
        exit();
    }
}

$resultado = mysqli_query($conexion, "SELECT id, nombre, email, rol FROM usuarios ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personal | Cinnamoon</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
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
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--sky);
            background-image:
                radial-gradient(ellipse at 10% 20%, rgba(191,126,70,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 90% 80%, rgba(76,43,8,0.05) 0%, transparent 50%);
            min-height: 100vh;
            padding: 40px 24px 60px;
            color: var(--espresso);
        }

        /* ── TOPBAR ── */
        .topbar {
            max-width: 1050px;
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

        .page-brand {
            font-family: 'Pacifico', cursive;
            color: var(--espresso);
            font-size: 1.3rem;
        }

        /* ── CONTAINER ── */
        .container {
            max-width: 1050px;
            margin: 0 auto;
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── PANEL HEADER ── */
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

        .panel-left { position: relative; z-index: 1; }

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

        .panel-header h1 {
            font-family: 'Pacifico', cursive;
            color: #fff;
            font-size: 1.7rem;
        }

        .btn-nuevo {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            text-decoration: none;
            padding: 11px 22px;
            border-radius: 15px;
            font-size: 0.82rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.22s;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .btn-nuevo:hover {
            background: var(--caramel);
            border-color: var(--caramel);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(191,126,70,0.35);
        }

        /* ── MSG ── */
        .msg {
            background: white;
            border-left: 4px solid #00b894;
            padding: 14px 20px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--espresso);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── TABLE WRAP ── */
        .table-wrap {
            background: var(--milky);
            border-radius: 0 0 28px 28px;
            box-shadow: 0 20px 50px var(--shadow-warm);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }

        thead tr { background: white; }

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
            padding: 17px 20px;
            border-bottom: 1px solid rgba(76,43,8,0.05);
            font-size: 0.88rem;
            color: var(--espresso);
            font-weight: 600;
            vertical-align: middle;
        }

        tbody tr { transition: background 0.18s; }
        tbody tr:hover { background: rgba(191,126,70,0.04); }
        tbody tr:last-child td { border-bottom: none; }

        /* ── USER CELL ── */
        .user-cell { display: flex; align-items: center; gap: 13px; }

        .avatar {
            width: 42px; height: 42px;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--caramel), var(--espresso));
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .avatar.is-you {
            background: linear-gradient(135deg, #00b894, #00cec9);
        }

        .user-name { font-size: 0.92rem; font-weight: 700; display: block; }
        .user-email { font-size: 0.75rem; color: #b09070; font-weight: 500; margin-top: 2px; display: block; }

        /* ── BADGE ROL ── */
        .badge {
            padding: 5px 13px;
            border-radius: 10px;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            display: inline-block;
        }

        .admin { background: var(--espresso); color: white; }
        .empleado { background: var(--sky); color: var(--espresso); }

        /* ── ACTIONS ── */
        .acciones { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

        .btn-accion {
            text-decoration: none;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 7px 13px;
            border-radius: 10px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: 1px solid transparent;
            cursor: pointer;
            font-family: inherit;
            background: none;
        }

        .editar { border-color: rgba(191,126,70,0.4); color: var(--caramel); background: rgba(191,126,70,0.07); }
        .editar:hover { background: var(--caramel); color: white; transform: translateY(-2px); }

        .borrar { border-color: rgba(214,48,49,0.25); color: #d63031; background: rgba(214,48,49,0.06); }
        .borrar:hover { background: #d63031; color: white; transform: translateY(-2px); }

        .cambiar { border-color: rgba(76,43,8,0.15); color: var(--espresso); background: rgba(76,43,8,0.05); }
        .cambiar:hover { background: var(--espresso); color: white; transform: translateY(-2px); }

        .you-tag { font-size: 0.72rem; color: #b09070; font-weight: 600; font-style: italic; }

        /* ── EDIT FORM inline ── */
        .edit-input {
            padding: 8px 12px;
            border: 2px solid rgba(76,43,8,0.1);
            border-radius: 11px;
            font-family: inherit;
            font-size: 0.82rem;
            color: var(--espresso);
            background: white;
            outline: none;
            width: 100%;
            margin-bottom: 6px;
            transition: border-color 0.2s;
        }

        .edit-input:focus { border-color: var(--caramel); }

        .btn-guardar {
            background: var(--caramel);
            color: white;
            border: none;
            padding: 9px 18px;
            border-radius: 11px;
            font-family: inherit;
            font-size: 0.78rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-guardar:hover { background: var(--espresso); transform: translateY(-2px); }

        @media (max-width: 768px) {
            body { padding: 20px 12px 40px; }
            .panel-header { flex-direction: column; align-items: flex-start; padding: 24px 22px; }
            th, td { padding: 13px 12px; }
        }
    </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <a href="admin.php" class="btn-volver">← Volver al Panel</a>
    <span class="page-brand">Cinnamoon</span>
</div>

<div class="container">

    <!-- HEADER -->
    <div class="panel-header">
        <div class="panel-left">
            <div class="panel-eyebrow">Cinamoon · Admin</div>
            <h1>Equipo Cinnamoon</h1>
        </div>
        <a href="registro.php" class="btn-nuevo">+ Nuevo Integrante</a>
    </div>

    <!-- TABLE -->
    <div class="table-wrap">

        <?php if (isset($_GET['mensaje'])): ?>
        <div class="msg">✨ Acción realizada con éxito.</div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Nombre y Email</th>
                    <th>Rol</th>
                    <th>Rango</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($resultado)): 
                    $iniciales = strtoupper(mb_substr($user['nombre'], 0, 2));
                    $es_yo = ($user['id'] == $_SESSION['usuario_id']);
                ?>
                <tr>
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $user['id']): ?>
                        <form action="ver_cuentas.php" method="POST">
                            <input type="hidden" name="id_usuario" value="<?php echo $user['id']; ?>">
                            <td colspan="3">
                                <input type="text"  name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" class="edit-input" required>
                                <input type="email" name="email"  value="<?php echo htmlspecialchars($user['email']); ?>"  class="edit-input" required>
                            </td>
                            <td>
                                <button type="submit" name="actualizar_datos" class="btn-guardar">💾 Guardar</button>
                            </td>
                        </form>
                    <?php else: ?>
                        <td>
                            <div class="user-cell">
                                <div class="avatar <?php echo $es_yo ? 'is-you' : ''; ?>"><?php echo $iniciales; ?></div>
                                <div>
                                    <span class="user-name"><?php echo htmlspecialchars($user['nombre']); ?></span>
                                    <span class="user-email"><?php echo htmlspecialchars($user['email']); ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?php echo $user['rol']; ?>"><?php echo $user['rol']; ?></span>
                        </td>
                        <td>
                            <?php if (!$es_yo): ?>
                                <?php $nuevo_rol = ($user['rol'] === 'admin') ? 'empleado' : 'admin'; ?>
                                <a href="ver_cuentas.php?cambiar_rol=<?php echo $user['id']; ?>&nuevo_rol=<?php echo $nuevo_rol; ?>" class="btn-accion cambiar">
                                    ⇅ Cambiar Rol
                                </a>
                            <?php else: ?>
                                <span class="you-tag">👤 Tú</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="acciones">
                                <a href="ver_cuentas.php?edit=<?php echo $user['id']; ?>" class="btn-accion editar">✏️ Editar</a>
                                <?php if (!$es_yo): ?>
                                    <a href="ver_cuentas.php?borrar=<?php echo $user['id']; ?>" class="btn-accion borrar" onclick="return confirm('¿Eliminar esta cuenta?')">🗑 Borrar</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>