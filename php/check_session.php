<?php
session_start();

$response = array();

if (isset($_SESSION['username'])) {
    // El usuario está autenticado en la sesión

    // Datos de conexión a la base de datos
    $hostname = "roundhouse.proxy.rlwy.net";
    $db_username = "root";
    $db_password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
    $database = "railway";
    $dbport = "21765";

    // Conectar a la base de datos
    $conn = new mysqli($hostname, $db_username, $db_password, $database, $dbport);

    // Verificar la conexión
    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = "Error de conexión: " . $conn->connect_error;
    } else {
        // Obtener el nombre de usuario de la sesión
        $username = $_SESSION['username'];

        // Consultar la base de datos para obtener más información del usuario
        $query = "SELECT * FROM usuarios WHERE username = '$username'";
        $result = $conn->query($query);

        // Verificar si se encontró el usuario en la base de datos
        if ($result && $result->num_rows > 0) {
            // Obtener los datos del usuario
            $user_data = $result->fetch_assoc();
            // Obtener el nombre de usuario y el user_id
            $username_db = $user_data['username'];
            $user_id = $user_data['user_id']; // Se asume que este es el nombre del campo en la tabla de usuarios
            // Agregar el nombre de usuario y el user_id al objeto de respuesta
            $response['status'] = 'logged_in';
            $response['username'] = $username_db;
            $response['user_id'] = $user_id;
        } else {
            // Si no se encuentra el usuario en la base de datos, mostrar un mensaje de error
            $response['status'] = 'not_logged_in';
        }

        // Cerrar la conexión
        $conn->close();
    }
} else {
    // Si el usuario no está autenticado en la sesión, mostrar un mensaje de no autenticado
    $response['status'] = 'not_logged_in';
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
