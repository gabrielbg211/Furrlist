<?php
// Datos de conexión a la base de datos
$hostname = "roundhouse.proxy.rlwy.net";
$username = "root";
$password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";

// Conexión a la base de datos
$conn = new mysqli($hostname, $username, $password, $database, $dbport);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Cambiar "Newusername" y "Newpassword" por "username" y "password" respectivamente
    $username = $_GET["username"];
    $password = $_GET["password"];
    
    // Consulta SQL para insertar un nuevo usuario en la tabla "usuarios"
    $sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado correctamente en la base de datos.";
    } else {
        echo "Error al registrar nuevo usuario en la base de datos: " . $conn->error;
    }
}