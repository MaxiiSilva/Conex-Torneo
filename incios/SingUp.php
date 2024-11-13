<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "conex"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['UserName'], $data['UserEmail'], $data['UserPw'])) {
    $userName = $data['UserName'];
    $userEmail = $data['UserEmail'];
    $userPw = $data['UserPw'];

    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["Mensaje" => "Correo electrónico no válido."]);
        exit();
    }

    if (strlen($userPw) < 6) {
        echo json_encode(["Mensaje" => "La contraseña debe tener al menos 6 caracteres."]);
        exit();
    }

    $result = $conn->query("SELECT * FROM seguidores WHERE UserName = '$userName' OR UserEmail = '$userEmail'");

    if ($result->num_rows > 0) {
        echo json_encode(["Mensaje" => "El nombre de usuario o el correo electrónico ya están registrados."]);
    } else {
        $sql = "INSERT INTO seguidores (UserName, UserEmail, UserPw) VALUES ('$userName', '$userEmail', '$userPw')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["Mensaje" => "Registrado con éxito."]);
        } else {
            echo json_encode(["Mensaje" => "Error al registrar: " . $conn->error]);
        }
    }
} else {
    echo json_encode(["Mensaje" => "Datos incompletos"]);
}

$conn->close();
?>