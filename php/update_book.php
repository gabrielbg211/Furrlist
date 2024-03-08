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

// Verificar si se recibieron datos del formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $idLibro = $_POST['id_libro'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $sinopsis = $_POST['sinopsis'];

    // Preparar la consulta SQL para actualizar los datos del libro
    $sqlDatos = "UPDATE libros SET titulo = ?, autor = ?, sinopsis = ? WHERE id_libro = ?";
    $stmtDatos = $conn->prepare($sqlDatos);
    $stmtDatos->bind_param("sssi", $titulo, $autor, $sinopsis, $idLibro);
    if (!$stmtDatos->execute()) {
        // Si hay un error al actualizar los datos del libro, mostrar el mensaje de error
        echo "Error al actualizar los datos del libro: " . $stmtDatos->error;
        exit();
    }

    // Si todo fue exitoso, mostrar "success"
    echo "success";

    // Cerrar la declaración
    $stmtDatos->close();
} else {
    // Si no se recibieron datos del formulario, mostrar un mensaje de error
    echo "Error: No se recibieron datos del formulario de edición";
}
?>
