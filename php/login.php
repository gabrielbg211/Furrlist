<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verificar si se enviaron datos de inicio de sesión
if(isset($_POST['username'], $_POST['password'])) {
    // Datos de conexión a la base de datos
    $hostname = "roundhouse.proxy.rlwy.net";
    $usernameDB = "root";
    $passwordDB = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
    $database = "railway";
    $dbport = "21765";

    // Crear conexión
    $conn = mysqli_connect($hostname, $usernameDB, $passwordDB, $database, $dbport);

    // Verificar conexión
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Obtener credenciales de inicio de sesión
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Prevenir inyección SQL
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Prevenir inyección SQL

    // Verificar si las credenciales son válidas en la base de datos
    $query = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        // Iniciar sesión y redirigir al usuario a la página principal
        session_start();
        $_SESSION['username'] = $username;
        echo "success"; // Devolver "success" si las credenciales son válidas
    } else {
        // Credenciales incorrectas
        echo "failed";
    }

    // Cerrar conexión
    mysqli_close($conn);
} else {
    // Datos de inicio de sesión no recibidos
    echo "Error: Datos de inicio de sesión no recibidos";
}
