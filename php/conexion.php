<?php

$host = "b6pkdnlv0pdrewsriiv3-mysql.services.clever-cloud.com";
$usuario = "up2hyvrxzjgcxzz7";
$password = "p0hxfjh42SouMdr3Qniq";
$database = "b6pkdnlv0pdrewsriiv3";

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