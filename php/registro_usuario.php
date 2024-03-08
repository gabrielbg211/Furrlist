<?php
// Datos de conexión a la base de datos
$hostname = "roundhouse.proxy.rlwy.net";
$username = "root";
$password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";

// Crear conexión
$conn = mysqli_connect($hostname, $username, $password, $database, $dbport);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Inicializar variable de mensaje
$message = "";

// Verificar si se enviaron datos de registro
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el nombre de usuario ya existe en la base de datos
    $check_query = "SELECT * FROM usuarios WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // El nombre de usuario ya existe
        $message = "Error: El nombre de usuario ya está en uso";
    } else {
        // Insertar datos del nuevo usuario en la base de datos
        $insert_query = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";
        if(mysqli_query($conn, $insert_query)) {
            // Registro exitoso

            // Iniciar sesión para el usuario recién registrado
            session_start();
            $_SESSION['username'] = $username;

            $message = "¡Registro exitoso!";
        } else {
            // Error al insertar datos en la base de datos
            $message = "Error al registrar el usuario: " . mysqli_error($conn);
        }
    }
} else {
    // Datos de registro no enviados
    $message = "Error: Datos de registro no recibidos";
}

// Cerrar conexión
mysqli_close($conn);

// Enviar el mensaje de vuelta al cliente
echo $message;
