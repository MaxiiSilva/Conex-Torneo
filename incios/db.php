<?php
header("Access-Control-Allow-Origin: http://localhost:8081");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // O métodos que estés usando
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true"); // Si necesitas enviar cookies, etc.
// Configuración de la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "conex"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión fallo: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos";

// Cerrar conexión
$conn->close();
?>