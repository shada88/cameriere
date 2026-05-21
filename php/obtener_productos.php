<?php
header("Content-Type: application/json");
require_once "conexion.php";

$sql = "SELECT idproductos, producto, precio FROM productos";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
    exit;
}

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);
$conn->close();
?>
