<?php
/**
 * Archivo de conexión oficial para Cinnamoon
 * Conecta tu PC local con la base de datos en la nube de Railway
 */

// Datos extraídos de tu pestaña "Public Network"
$host = getenv('MYSQLHOST') ?: 'interchange.proxy.rlwy.net'; 
$user = getenv('MYSQLUSER') ?: 'root'; 
$pass = getenv('MYSQLPASSWORD') ?: 'hioHnEajRxivrtyKpVPpjpPGbvaVnQYh'; 
$db   = getenv('MYSQLDATABASE') ?: 'reposteria_db'; 
$port = getenv('MYSQLPORT') ?: '26756'; 

// Crear la conexión
$conexion = mysqli_connect($host, $user, $pass, $db, $port);

// Verificar si la conexión funciona
if (!$conexion) {
    die("Error de conexión a Cinnamoon: " . mysqli_connect_error());
}

// Configurar para que las tildes y la ñ se vean bien
mysqli_set_charset($conexion, "utf8");

// Si ves esta página en blanco al ejecutarla, ¡estás conectado con éxito!
?>