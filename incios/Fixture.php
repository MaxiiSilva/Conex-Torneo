<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "conex"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]));
}

$sql = "SELECT p.fecha, 
               e_local.nombre AS equipo_local, 
               e_visitante.nombre AS equipo_visitante, 
               p.goles_local, p.goles_visitante
        FROM partidos p
        JOIN equipos e_local ON p.equipo_local_id = e_local.id
        JOIN equipos e_visitante ON p.equipo_visitante_id = e_visitante.id
        ORDER BY p.fecha ASC"; 

$result = $conn->query($sql);

$partidos = [];
while($row = $result->fetch_assoc()) {
    $partidos[$row['fecha']][] = $row;
}

echo json_encode($partidos);

$conn->close();
?>
