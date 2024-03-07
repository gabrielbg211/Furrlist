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
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si se enviaron datos del formulario
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Recuperar los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hashear la contraseña antes de almacenarla en la base de datos
    $password_hasheada = password_hash($password, PASSWORD_DEFAULT);
    
    // Insertar los datos en la base de datos
    $sql_insert = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password_hasheada')";
    
    if (mysqli_query($conn, $sql_insert)) {
        // Registro exitoso
        $response['success'] = true;
        $response['message'] = "Registro exitoso";
    } else {
        // Error al insertar en la base de datos
        $response['success'] = false;
        $response['message'] = "Error al registrar usuario: " . mysqli_error($conn);
    }
    
    // Devolver la respuesta como JSON
    echo json_encode($response);
} else {
    // Datos del formulario no recibidos
    $response['success'] = false;
    $response['message'] = "Error: Datos del formulario no recibidos";
    // Devolver la respuesta como JSON
    echo json_encode($response);
}
