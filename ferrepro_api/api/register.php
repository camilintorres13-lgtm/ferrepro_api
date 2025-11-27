<?php
header("Content-Type: application/json");
require_once "../config/db.php";

// Validar que los datos lleguen por POST
if (
    empty($_POST["nombre"]) ||
    empty($_POST["correo"]) ||
    empty($_POST["usuario"]) ||
    empty($_POST["password"]) ||
    empty($_POST["rol"])
) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    exit;
}

// Capturar datos
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$usuario = $_POST["usuario"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$rol = $_POST["rol"];

// Preparar consulta CORREGIDA con los nombres reales de tu BD
$sql = "INSERT INTO usuarios (nombre, correo, usuario, password, rol) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $correo, $usuario, $password, $rol);

// Ejecutar
if ($stmt->execute()) {
    echo json_encode(["success" => "Usuario registrado correctamente"]);
} else {
    echo json_encode(["error" => "Error al registrar usuario"]);
}
?>
