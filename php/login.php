<?php
session_start();
require_once "conexion.php"; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $rol = $_POST["role"];

    if (empty($correo) || empty($password)) {
        echo "<script>alert('Por favor completa todos los campos.'); window.history.back();</script>";
        exit;
    }

    // Si es cliente
    if ($rol === "cliente") {
        $sql = "SELECT * FROM cliente WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($password === $user["contraseña"]) { // Puedes reemplazar esto con password_verify() si usas contraseñas encriptadas
                $_SESSION["idCliente"] = $user["idCliente"];
                $_SESSION["correo"] = $user["correo"];
                $_SESSION["rol"] = "cliente";

                header("Location: homecliente.php");
                exit;
            } else {
                echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Usuario no encontrado como cliente.'); window.history.back();</script>";
            exit;
        }
    }

    // Si es administrador/encargado
    elseif ($rol === "admin") {
        $sql = "SELECT * FROM encargado WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($password === $user["contraseña"]) {
                $_SESSION["idEncargado"] = $user["idEncargado"];
                $_SESSION["correo"] = $user["correo"];
                $_SESSION["rol"] = "admin";

                header("Location: homeadmin.php");
                exit;
            } else {
                echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Usuario no encontrado como administrador.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Tipo de usuario inválido.'); window.history.back();</script>";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
