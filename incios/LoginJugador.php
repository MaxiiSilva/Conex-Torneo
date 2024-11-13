<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "conex"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]));
}
$data = json_decode(file_get_contents("php://input"), true);
$nombre_completo = $data['nombre_completo'] ?? '';
$claveKyc = $data['claveKyc'] ?? '';


if (!$nombre_completo || !$claveKyc) {
    echo json_encode(["success" => false, "message" => "Faltan datos de autenticación"]);
    exit;
}

$sql = "SELECT j.id 
        FROM jugadoresaccess ja 
        JOIN jugadores j ON j.id = ja.jugador_id 
        WHERE ja.nombre_completo = '$nombre_completo' 
        AND ja.claveKyc = '$claveKyc'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $jugador_id = $result->fetch_assoc()['id'];
    echo json_encode(["success" => true, "jugador_id" => $jugador_id]);
} else {
    echo json_encode(["success" => false, "message" => "El nombre completo o la clave son incorrectos."]);
}

$conn->close();
?>