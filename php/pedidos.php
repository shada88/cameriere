<?php
session_start();
header("Content-Type: application/json");
require_once "conexion.php";

// ⚠️ Asegúrate de que el idCliente se guarde en la sesión al iniciar sesión
$idCliente = $_SESSION['idCliente'] ?? null;

if (!$idCliente) {
    echo json_encode([]);
    exit;
}

// Obtener todas las comandas del cliente con su total
$sql = "SELECT c.idComanda, c.CodOrden, c.idCame,
               SUM(d.Cantidad * p.Precio) AS Total
        FROM comanda c
        JOIN detalle_comanda d ON c.idComanda = d.idComanda
        JOIN productos p ON d.idProductos = p.idProductos
        WHERE c.idCliente = ?
        GROUP BY c.idComanda, c.CodOrden, c.idCame
        ORDER BY c.idComanda DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCliente);
$stmt->execute();
$result = $stmt->get_result();

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    // Obtener productos de cada comanda
    $sqlProd = "SELECT p.Producto, d.Cantidad, p.Precio
                FROM detalle_comanda d
                JOIN productos p ON d.idProductos = p.idProductos
                WHERE d.idComanda = ?";
    $stmtProd = $conn->prepare($sqlProd);
    $stmtProd->bind_param("i", $row['idComanda']);
    $stmtProd->execute();
    $resultProd = $stmtProd->get_result();

    $productos = [];
    while ($prod = $resultProd->fetch_assoc()) {
        $productos[] = $prod;
    }

    $row['productos'] = $productos;
    $pedidos[] = $row;

    $stmtProd->close();
}

echo json_encode($pedidos);

$stmt->close();
$conn->close();
?>
