<?php

header("Access-Control-Allow-Origin: http://192.168.1.10:8080");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'config.php'; // Incluir el archivo que contiene las variables de conexión a la base de datos

// Verificar si se recibió el ID del libro a eliminar
if(isset($_POST['id_libro'])) {
    // Obtener el ID del libro desde la solicitud POST
    $id_libro = $_POST['id_libro'];

    // Conectar a la base de datos
    $conn = new mysqli($hostname, $db_username, $db_password, $database, $dbport);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Preparar la consulta para eliminar el libro
    $sql = "DELETE FROM libros WHERE id_libro = $id_libro";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        // La eliminación fue exitosa
        echo "success";
    } else {
        // Error al eliminar el libro
        echo "Error al eliminar el libro: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se recibió el ID del libro a eliminar
    echo "ID del libro no recibido";
}
