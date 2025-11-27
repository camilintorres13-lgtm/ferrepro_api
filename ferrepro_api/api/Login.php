<?php
// =============================================
// ARCHIVO: login.php
// FUNCIÓN: Iniciar sesión de usuarios en FerrePro
// =============================================

include("../config/db.php");

// Recibir datos enviados en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validar que no estén vacíos
if (empty($data["email"]) || empty($data["password"])) {
    echo json_encode(["error" => "Email y contraseña obligatorios"]);
    exit;
}

// Asignación de variables
$email = $data["email"];
$password = $data["password"];

// Buscar el usuario por email
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

// Verificar si el usuario existe
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verificación de la contraseña
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

// Cierre de la conexión
$stmt->close();
$conn->close();
?>
