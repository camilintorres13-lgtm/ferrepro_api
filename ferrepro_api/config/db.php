<?php
// ================================
// ARCHIVO: db.php
// FUNCIÓN: Conexión a la base de datos MySQL del proyecto FerrePro
// AUTOR: Camilo Torres
// ================================

// Datos del servidor
$host = "localhost";     // Servidor de la base de datos
$user = "root";          // Usuario por defecto de XAMPP
$password = "";          // Contraseña (vacía por defecto)
$database = "ferrepro";  // Nombre de la base de datos

// Creación de la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificación de errores en la conexión
if ($conn->connect_error) {
    die("❌ Error de conexión a la base de datos: " . $conn->connect_error);
}

// Si todo está correcto, la conexión queda activa
?>
