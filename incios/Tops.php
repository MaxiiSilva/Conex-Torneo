<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "conex"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = [
    'goleadores' => "SELECT j.nombre, j.apellido, j.posicion, j.goles, e.nombre AS equipo FROM jugadores j JOIN equipos e ON j.equipo_id = e.id ORDER BY j.goles DESC LIMIT 5",
    'asistencias' => "SELECT j.nombre, j.apellido, j.posicion, j.asistencias, e.nombre AS equipo FROM jugadores j JOIN equipos e ON j.equipo_id = e.id ORDER BY j.asistencias DESC LIMIT 5",
    'tarjetas_amarillas' => "SELECT j.nombre, j.apellido, j.posicion, j.tarjetas_amarillas, e.nombre AS equipo FROM jugadores j JOIN equipos e ON j.equipo_id = e.id ORDER BY j.tarjetas_amarillas DESC LIMIT 5",
    'tarjetas_rojas' => "SELECT j.nombre, j.apellido, j.posicion, j.tarjetas_rojas, e.nombre AS equipo FROM jugadores j JOIN equipos e ON j.equipo_id = e.id ORDER BY j.tarjetas_rojas DESC LIMIT 5"
];

$resultados = [];

foreach ($sql as $key => $query) {
    $resultado = $conn->query($query);
    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $resultados[$key][] = $row;
        }
    }
}

echo json_encode($resultados);

$conn->close();
?>