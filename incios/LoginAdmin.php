<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "conex");

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(["success" => false, "Mensaje" => "Error de conexión"]));
}

// Obtenemos los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data['usuario'] ?? null;
$contraseña = $data['contraseña'] ?? null;

// Verifica que los datos existen
if (!$usuario || !$contraseña) {
    echo json_encode(["success" => false, "Mensaje" => "Datos incompletos"]);
    exit;
}

// Busca  el correo en la base de datos
$result = $conn->query("SELECT contraseña FROM administrador WHERE usuario = '$usuario'");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["success" => $row['contraseña'] === $contraseña]);
} else {
    echo json_encode(["success" => false, "Mensaje" => "Administrador no encontrado"]);
}

// Cerrar la conexión
$conn->close();
?>