<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "Mensaje" => "Error de conexión"]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['UserEmail']) || empty($data['UserPw'])) {
    echo json_encode(["success" => false, "Mensaje" => "Datos incompletos"]);
    exit;
}

$result = $conn->query("SELECT UserPw FROM seguidores WHERE UserEmail = '{$data['UserEmail']}'");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["success" => $row['UserPw'] === $data['UserPw']]);
} else {
    echo json_encode(["success" => false, "Mensaje" => "Email no encontrado"]);
}

$conn->close();
?>