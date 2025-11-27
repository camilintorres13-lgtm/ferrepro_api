<?php
// =============================================
// ARCHIVO: controlador.php
// FUNCIÓN: Controlar si es login o registro
// =============================================

// Recibir datos desde la interfaz
$data = json_decode(file_get_contents("php://input"), true);

// Validar tipo de operación
if ($data["tipo"] === "registro") {
    include("register.php");
} else if ($data["tipo"] === "login") {
    include("login.php");
} else {
    echo json_encode(["error" => "Operación no válida"]);
}
?>
