<?php

$host = "localhost";
$usuario = "root";
$password = "";
$database = "cameriere";

$conn = new mysqli($host, $usuario, $password, $database);

if ($conn->connect_error) {

    echo json_encode([
        "success" => false,
        "error" => $conn->connect_error
    ]);

    exit;
}

$conn->set_charset("utf8");
?>