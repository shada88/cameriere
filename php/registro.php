<?php
include(__DIR__ . "/conexion.php");
header("Content-Type: application/json");

// Recibir datos del formulario (POST o JSON)
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) $data = $_POST;

// Obtener valores
$correo = $data["username"] ?? null;
$contraseña = $data["password"] ?? null;
$role = $data["role"] ?? null;

// Validaciones
if (!$correo || !$contraseña || !$role) {
    echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    exit;
}

// Definir tabla según el rol
$tablas = [
    "cliente" => ["tabla" => "cliente", "correo" => "correo", "clave" => "contraseña"],
    "admin"   => ["tabla" => "encargado", "correo" => "correo", "clave" => "contraseña"]
];

// Validar rol
if (!isset($tablas[$role])) {
    echo json_encode(["success" => false, "message" => "Rol no válido."]);
    exit;
}

// Inserción segura
$t = $tablas[$role];
$sql = "INSERT INTO {$t['tabla']} ({$t['correo']}, {$t['clave']}) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $correo, $contraseña);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Usuario registrado correctamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al registrar: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
