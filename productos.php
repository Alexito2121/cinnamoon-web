<?php
session_start();
include 'conexion.php';

// Verificamos si hay sesión; si no, el rol es 'cliente' por defecto
$rol = $_SESSION['rol'] ?? 'cliente'; 

// Consultamos los productos
$query = "SELECT * FROM productos ORDER BY id DESC";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Dulce Migaja | Catálogo</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --pink: #d81b60; --dark: #2d3436; }
        body { background: #fdf2f5; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 40px 20px; }
        .brand { font-family: 'Pacifico', cursive; color: var(--pink); font-size: 2.5rem; text-align: center; margin: 0; }
        
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; max-width: 1100px; margin: 40px auto; }
        .card { background: white; border-radius: 25px; padding: 20px; box-shadow: 0 10px 30px rgba(216, 27, 96, 0.05); transition: 0.3s; position: relative; }
        .card img { width: 100%; height: 200px; object-fit: cover; border-radius: 20px; margin-bottom: 15px; }
        .card h3 { margin: 10px 0; color: var(--dark); }
        .card .price { color: var(--pink); font-weight: 800; font-size: 1.4rem; display: block; margin-bottom: 15px; }

        /* Herramientas de Gestión */
        .admin-tools { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f0f0; padding-top: 15px; }
        .btn-edit { color: #0984e3; text-decoration: none; font-size: 13px; font-weight: 700; }
        .btn-delete { color: #d63031; background: none; border: none; cursor: pointer; font-size: 13px; font-weight: 700; }

        /* Botón Flotante para Agregar (Solo Admin y Empleado) */
        .btn-add-float { position: fixed; bottom: 40px; right: 40px; background: var(--pink); color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 10px 30px rgba(216, 27, 96, 0.3); text-decoration: none; z-index: 100; }
    </style>
</head>
<body>

    <h1 class="brand">La Dulce Migaja</h1>

    <div class="grid">
        <?php while($p = mysqli_fetch_assoc($resultado)): ?>
        <div class="card">
            <img src="<?php echo $p['imagen']; ?>" alt="Dulce">
            <h3><?php echo $p['nombre']; ?></h3>
            <span class="price">RD$ <?php echo number_format($p['precio'], 2); ?></span>

            <!-- LÓGICA DE BOTONES EN LA TARJETA -->
            <?php if ($rol === 'admin'): ?>
                <!-- El ADMIN ve EDITAR y BORRAR -->
                <div class="admin-tools">
                    <a href="editar_producto.php?id=<?php echo $p['id']; ?>" class="btn-edit"><i class="fa-solid fa-pen"></i> EDITAR</a>
                    <button onclick="borrar(<?php echo $p['id']; ?>)" class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                </div>
            <?php elseif ($rol === 'empleado'): ?>
                <!-- EL EMPLEADO no ve botones en la tarjeta (solo el de agregar abajo) -->
                <p style="font-size: 10px; color: #ccc;">Vista de Inventario</p>
            <?php endif; ?>
            <!-- El CLIENTE no ve nada de lo anterior -->
        </div>
        <?php endwhile; ?>
    </div>

    <!-- LÓGICA DEL BOTÓN AGREGAR -->
    <?php if ($rol === 'admin' || $rol === 'empleado'): ?>
        <!-- Solo Admin y Empleado ven el botón flotante para agregar -->
        <a href="nuevo_producto.php" class="btn-add-float"><i class="fa-solid fa-plus"></i></a>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function borrar(id) {
            Swal.fire({
                title: '¿Eliminar producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d81b60',
                confirmButtonText: 'Sí, borrar'
            }).then((res) => { if (res.isConfirmed) { window.location.href = 'eliminar_producto.php?id=' + id; } });
        }
    </script>
</body>
</html>