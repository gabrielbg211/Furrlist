<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

$hostname = "roundhouse.proxy.rlwy.net";
$db_username = "root";
$db_password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";

// Conectar a la base de datos
$conn = new mysqli($hostname, $db_username, $db_password, $database, $dbport);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Verificar si se recibió el ID del libro
if (isset($_GET['id_libro'])) {
    // Obtener el ID del libro
    $idLibro = $_GET['id_libro'];

    // Preparar la consulta SQL para obtener los detalles del libro por su ID
    $sql = "SELECT * FROM libros WHERE id_libro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idLibro);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener los detalles del libro como un array asociativo
        $libro = $result->fetch_assoc();

        // Convertir el array asociativo a JSON y devolverlo como respuesta
        echo json_encode($libro);
    } else {
        // No se encontró ningún libro con el ID especificado
        echo json_encode(null);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    // No se recibió el ID del libro
    echo "Error: No se proporcionó el ID del libro";
}