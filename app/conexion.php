<?php
// Permitir solicitudes desde el origen específico
header("Access-Control-Allow-Origin: http://192.168.1.10:8080");

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cambiar "Newusername" y "Newpassword" por "username" y "password" respectivamente
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Consulta SQL para insertar un nuevo usuario en la tabla "usuarios"
    $sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo usuario registrado correctamente.";
        
        // Guardar la información del nuevo usuario en el localStorage
        echo "<script>
                var users = JSON.parse(localStorage.getItem('users')) || {};
                users['$username'] = { password: '$password', libros: [] };
                localStorage.setItem('users', JSON.stringify(users));
              </script>";
    } else {
        echo "Error al registrar nuevo usuario: " . $conn->error;
    }
}

