<?php
include("../config/db.php");
$data = json_decode(file_get_contents("php://input"), true);

if ($data["tipo"] == "registro") {

    $stmt = $conn->prepare("INSERT INTO usuarios 
    (nombre, email, password, rol, fecha_nacimiento, telefono, direccion, sucursal, codigo_admin) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $hash = password_hash($data["password"], PASSWORD_DEFAULT);

    $stmt->bind_param(
        "sssssssss",
        $data["nombre"],
        $data["email"],
        $hash,
        $data["rol"],
        $data["fecha"],
        $data["telefono"],
        $data["direccion"],
        $data["sucursal"],
        $data["codigo_admin"]
    );

    $stmt->execute();
    echo json_encode(["success"=>"Registrado correctamente"]);
}

if ($data["tipo"] == "login") {

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email=?");
    $stmt->bind_param("s", $data["email"]);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if (!$res || !password_verify($data["password"], $res["password"])) {
        echo json_encode(["error"=>"Credenciales inválidas"]);
        exit;
    }

    echo json_encode([
        "success"=>"Login correcto",
        "rol"=>$res["rol"],
        "nombre"=>$res["nombre"]
    ]);
}
