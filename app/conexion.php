<?php

// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir los métodos GET y POST desde el origen especificado
header("Access-Control-Allow-Methods: GET, POST");

// Permitir los encabezados personalizados y las cabeceras de solicitud estándar
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// Datos de conexión a la base de datos
$hostname = "roundhouse.proxy.rlwy.net";
$username = "root";
$password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";
$database_url = "mysql://root:FfgBbhdC14-d3g5DDA6F5fec43cHBf3f@mysql.railway.internal:3306/railway";

// Conexión a la base de datos
$conn = new mysqli($hostname, $username, $password, $database, $dbport, $database_url);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Consulta SQL para verificar si el usuario ya existe
    $check_query = "SELECT COUNT(*) AS count FROM usuarios WHERE username = '$username'";
    $result = $conn->query($check_query);
    $row = $result->fetch_assoc();
    $user_count = $row['count'];
    
    if ($user_count > 0) {
        echo "El nombre de usuario ya está en uso.";
    } else {
        // Consulta SQL para insertar un nuevo usuario en la tabla "usuarios"
        $insert_query = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";
        
        if ($conn->query($insert_query) === TRUE) {
            echo "Nuevo usuario registrado correctamente.";
        } else {
            echo "Error al registrar nuevo usuario: " . $conn->error;
        }
    }
}
