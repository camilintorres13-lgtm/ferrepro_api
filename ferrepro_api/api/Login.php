<?php

// Mostrar errores SOLO para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

include("../config/db.php");

$data = json_decode(file_get_contents("php://input"), true);

$usuario = $data["usuario"] ?? null;
$password = $data["password"] ?? null;

if (!$usuario || !$password) {
    echo json_encode(["error" => "Usuario y contraseña obligatorios"]);
    exit;
}

$sql = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$sql->bind_param("s", $usuario);
$sql->execute();
$resultado = $sql->get_result();

if ($resultado->num_rows === 1) {
    $user = $resultado->fetch_assoc();

    if (password_verify($password, $user["password"])) {
        echo json_encode([
            "success" => "Login correcto",
            "rol" => $user["rol"],
            "nombre" => $user["nombre"]
        ]);
    } else {
        echo json_encode(["error" => "Contraseña incorrecta"]);
    }
} else {
    echo json_encode(["error" => "Usuario no encontrado"]);
}
