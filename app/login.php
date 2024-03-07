<?php
// Datos de conexión a la base de datos
$hostname = "roundhouse.proxy.rlwy.net";
$username = "root";
$password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";

// Establecer conexión con la base de datos
$conexion = new mysqli($hostname, $username, $password, $database, $dbport);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Manejar el inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
    $resultado = $conexion->query($sql);

   if ($resultado->num_rows == 1) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION["username"] = $username;
        // Obtener el ID de usuario
        $fila = $resultado->fetch_assoc();
        $_SESSION["user_id"] = $fila["user_id"];
        echo "success";
    } else {
        // Credenciales incorrectas
        echo "error";
    }
    exit(); // Terminar el script después de enviar la respuesta
}

// Cerrar conexión
$conexion->close();
