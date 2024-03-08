<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

// Conexión a la base de datos
$hostname = "roundhouse.proxy.rlwy.net";
$db_username = "root";
$db_password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";

// Obtener el nombre de usuario del usuario activo (asumiendo que está almacenado en una variable de sesión)
session_start();
$loggedUser = $_SESSION['username']; // Ajusta esto según cómo hayas guardado el nombre de usuario en la sesión

// Crear la conexión
$conn = new mysqli($hostname, $db_username, $db_password, $database, $dbport);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los libros del usuario activo
$sql = "SELECT * FROM libros WHERE username = '$loggedUser'";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Convertir los resultados a un arreglo asociativo
    $books = array();
    while ($row = $result->fetch_assoc()) {
        // Agregar el libro al arreglo
        $row['portada'] = 'app/img/libro-pata.png'; // Agregar la ruta de la portada
        $books[] = $row;
    }
    // Devolver los libros como JSON
    echo json_encode($books);
} else {
    // No se encontraron libros para el usuario activo
    echo "No hay libros disponibles para este usuario.";
}

// Cerrar la conexión
$conn->close();
?>
