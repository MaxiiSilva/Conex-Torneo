<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "conex";

$conexion = mysqli_connect($servername, $username, $password, $dbname);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$query = "SELECT nombre, escudo_url FROM equipos";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) > 0) {
    $equipos = [];
    while ($equipo = mysqli_fetch_assoc($resultado)) {
        $equipos[] = $equipo; 
    }
    echo json_encode($equipos);
} else {
    echo json_encode(["error" => "No se encontraron equipos"]);
}

mysqli_close($conexion);
?>