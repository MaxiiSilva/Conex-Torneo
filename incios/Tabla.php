<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conex";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id, nombre, escudo_url, puntos, partidos_jugados, partidos_ganados, partidos_empatados, partidos_perdidos, goles_favor, goles_contra, diferencia_goles FROM equipos ORDER BY puntos DESC";

$result = $conn->query($sql);

$equipos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $equipos[] = $row;
    }
}

echo json_encode($equipos);

$conn->close();
?>
