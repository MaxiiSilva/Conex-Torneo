<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "conex"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$jugador_id = $_GET['jugador_id'];

$sql = "
    SELECT j.id, j.nombre, j.apellido, j.edad, j.posicion, j.numero_casaca, 
           j.equipo_id, e.nombre as nombre_equipo, j.goles, j.tarjetas_amarillas, 
           j.tarjetas_rojas, j.asistencias, ja.nombre_completo, ja.claveKyc
    FROM jugadores j
    JOIN jugadoresaccess ja ON j.id = ja.jugador_id
    LEFT JOIN equipos e ON j.equipo_id = e.id
    WHERE ja.jugador_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jugador_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $jugador = $result->fetch_assoc();
    echo json_encode($jugador);
} else {
    echo json_encode(["error" => "Jugador no encontrado"]);
}

$stmt->close();
$conn->close();
?>