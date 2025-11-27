<?php
// =============================================
// ARCHIVO: register.php
// FUNCIÓN: Registro de usuarios en la plataforma FerrePro
// =============================================

// Incluir la conexión a la base de datos
include("../config/db.php");

// Recibir los datos en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validar que los campos obligatorios no estén vacíos
if (
    empty($data["email"]) ||
    empty($data["password"]) ||
    empty($data["rol"])
) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    exit;
}

// Asignación de variables
$nombre = $data["nombre"];
$email = $data["email"];
$password = password_hash($data["password"], PASSWORD_DEFAULT); // Encriptación de la contraseña
$rol = $data["rol"];
$fecha = $data["fecha"];
$telefono = $data["telefono"];
$direccion = $data["direccion"];
$sucursal = $data["sucursal"];
$codigo_admin = $data["codigo_admin"];

// Preparar consulta SQL para insertar usuario
$sql = "INSERT INTO usuarios (nombre, email, password, rol, fecha_nacimiento, telefono, direccion, sucursal, codigo_admin)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Preparar la consulta
$stmt = $conn->prepare($sql);

// Asignar valores a la consulta
$stmt->bind_param("sssssssss", $nombre, $email, $password, $rol, $fecha, $telefono, $direccion, $sucursal, $codigo_admin);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(["success" => "Registrado correctamente"]);
} else {
    echo json_encode(["error" => "Error al registrar usuario"]);
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
