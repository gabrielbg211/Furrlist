<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    echo "Error: No se ha iniciado sesión.";
    exit();
}

// Datos de conexión a la base de datos
$hostname = "roundhouse.proxy.rlwy.net";
$username = "root";
$password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";

// Crear conexión
$conn = new mysqli($hostname, $username, $password, $database, $dbport);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$sinopsis = $_POST['sinopsis'];
$username = $_SESSION['username']; // Obtener el nombre de usuario de la sesión actual
$id_usuario = $_SESSION['user_id']; // Obtener el ID de usuario de la sesión actual

// Preparar la consulta SQL para insertar el libro en la base de datos
$sql = "INSERT INTO libros (titulo, autor, sinopsis, username, id_usuario) VALUES ('$titulo', '$autor', '$sinopsis', '$username', '$id_usuario')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "success"; // Enviar mensaje de éxito
} else {
    echo "Error al guardar el libro en la base de datos: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
