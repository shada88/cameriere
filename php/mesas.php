<?php
header("Content-Type: application/json");
require_once "conexion.php";

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {
    case "listar":
        $sql = "SELECT idCame, Mesa FROM came";
        $result = $conn->query($sql);
        $mesas = [];
        while ($row = $result->fetch_assoc()) {
            $mesas[] = $row;
        }
        echo json_encode($mesas);
        break;

    case "guardar":
        if (isset($_POST['mesa'])) {
            $mesa = $_POST['mesa'];
            $sql = "INSERT INTO came (Mesa) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $mesa);
            echo json_encode(["success" => $stmt->execute()]);
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "No se recibió la mesa"]);
        }
        break;

    case "eliminar":
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "DELETE FROM came WHERE idCame = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            echo json_encode(["success" => $stmt->execute()]);
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "No se recibió el ID"]);
        }
        break;

    case "editar":
        if (isset($_POST['id']) && isset($_POST['mesa'])) {
            $id = intval($_POST['id']);
            $mesa = $_POST['mesa'];
            $sql = "UPDATE came SET Mesa = ? WHERE idCame = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $mesa, $id);
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
