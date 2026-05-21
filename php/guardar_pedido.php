<?php
header("Content-Type: application/json");
require_once "conexion.php";

// Datos recibidos desde el cliente
$data = json_decode(file_get_contents("php://input"), true);

$idCliente = $data['idCliente'];   // lo obtienes de la sesión del cliente
$idCame    = $data['idCame'];      // mesa seleccionada
$productos = $data['productos'];   // array con {idProductos, cantidad}

// Generar código de orden único
$codOrden = uniqid("ORD-");

// Calcular cantidad total de productos
$cantidadTotal = array_sum(array_column($productos, "cantidad"));

// Insertar en comanda
$sql = "INSERT INTO comanda (CodOrden, idCame, CantidadProductos, idCliente) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siii", $codOrden, $idCame, $cantidadTotal, $idCliente);

if ($stmt->execute()) {
    $idComanda = $stmt->insert_id;

    // Insertar detalle de la comanda
    $sqlDetalle = "INSERT INTO detalle_comanda (idComanda, idProductos, Cantidad) VALUES (?, ?, ?)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    foreach ($productos as $prod) {
        $stmtDetalle->bind_param("iii", $idComanda, $prod['idProductos'], $prod['cantidad']);
        $stmtDetalle->execute();
    }

    // =========================
// TOTAL DEL PEDIDO
// =========================
$total = 0;

foreach ($productos as $prod) {

    $sqlPrecio = "SELECT Precio FROM productos WHERE idProductos = ?";
    $stmtPrecio = $conn->prepare($sqlPrecio);

    $stmtPrecio->bind_param("i", $prod['idProductos']);
    $stmtPrecio->execute();

    $resPrecio = $stmtPrecio->get_result();
    $productoDB = $resPrecio->fetch_assoc();

    $total += $productoDB['Precio'] * $prod['cantidad'];
}

// =========================
// ENVIAR AL WEBSOCKET
// =========================
$payload = json_encode([
    "orden" => $codOrden,
    "cliente" => $idCliente,
    "mesa" => $idCame,
    "total" => $total
]);

$options = [
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/json\r\n",
        "content" => $payload
    ]
];

$context = stream_context_create($options);

@file_get_contents(
    "http://localhost:8000/nuevo-pedido",
    false,
    $context
);

// =========================
// RESPUESTA
// =========================
echo json_encode([
    "success" => true,
    "idComanda" => $idComanda,
    "codOrden" => $codOrden
]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$stmt->close();
$conn->close();
?>
