<?php
header("Content-Type: application/json");
require_once "conexion.php";

$sql = "SELECT c.idComanda, c.CodOrden, c.idCliente, c.idCame,
               SUM(d.Cantidad * p.Precio) AS Total
        FROM comanda c
        JOIN detalle_comanda d ON c.idComanda = d.idComanda
        JOIN productos p ON d.idProductos = p.idProductos
        GROUP BY c.idComanda, c.CodOrden, c.idCliente, c.idCame
        ORDER BY c.idComanda DESC";

$result = $conn->query($sql);
$facturas = [];
while ($row = $result->fetch_assoc()) {
    $facturas[] = $row;
}
echo json_encode($facturas);
$conn->close();
?>
