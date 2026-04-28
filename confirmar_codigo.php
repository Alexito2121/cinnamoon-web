<?php
session_start();

if (isset($_POST['codigo_usuario'])) {
    $codigo_tecleado = $_POST['codigo_usuario'];
    $codigo_real = $_SESSION['codigo_verificacion'] ?? '';

    if ($codigo_tecleado == $codigo_real) {
        // Código correcto: Damos permiso para cambiar la clave
        $_SESSION['codigo_validado'] = true;
        header("Location: nueva_clave.php");
        exit();
    } else {
        // Código incorrecto: Volvemos atrás con error
        header("Location: verificar_codigo.php?error=1");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>