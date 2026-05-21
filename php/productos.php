<?php
header("Content-Type: application/json");
require_once "conexion.php";

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {
    case "listar":
        $sql = "SELECT idProductos, Producto, Precio FROM productos";
        $result = $conn->query($sql);
        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        echo json_encode($productos);
        break;

    case "guardar":
        if (isset($_POST['producto']) && isset($_POST['precio'])) {
            $producto = $_POST['producto'];
            $precio = floatval($_POST['precio']);
            $sql = "INSERT INTO productos (Producto, Precio) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sd", $producto, $precio);
            echo json_encode(["success" => $stmt->execute()]);
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
        }
        break;

    case "eliminar":
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "DELETE FROM productos WHERE idProductos = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            echo json_encode(["success" => $stmt->execute()]);
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "No se recibió el ID"]);
        }
        break;

    case "editar":
        if (isset($_POST['id']) && isset($_POST['producto']) && isset($_POST['precio'])) {
            $id = intval($_POST['id']);
            $producto = $_POST['producto'];
            $precio = floatval($_POST['precio']);
            $sql = "UPDATE productos SET Producto = ?, Precio = ? WHERE idProductos = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdi", $producto, $precio, $id);
            echo json_encode(["success" => $stmt->execute()]);
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
        }
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
}

$conn->close();
?>
