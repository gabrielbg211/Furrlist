<?php
header("Access-Control-Allow-Origin: http://192.168.1.10:8080");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

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
    $rutaPortadaActual = $_POST['ruta_portada']; // Obtener la ruta de la portada actual desde el formulario

    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
    // Obtener el nombre del archivo cargado
    $nombreArchivo = $_FILES['portada']['name'];

    // Generar un nombre único para el archivo
    $nombreUnico = uniqid() . '.png';

    // Mover el archivo cargado a una ubicación adecuada en el servidor con el nombre único
    $rutaArchivo = '../php/portada_libros/' . $nombreUnico;
    if (move_uploaded_file($_FILES['portada']['tmp_name'], $rutaArchivo)) {
        // Actualizar la portada del libro en la base de datos
        $sqlPortada = "UPDATE libros SET imagen_portada = ? WHERE id_libro = ?";
        $stmtPortada = $conn->prepare($sqlPortada);
        $stmtPortada->bind_param("si", $nombreUnico, $idLibro);
        if (!$stmtPortada->execute()) {
            // Si hay un error al actualizar la portada, mostrar el mensaje de error
            echo "Error al actualizar la portada del libro: " . $stmtPortada->error;
            exit();
        }
    } else {
        // Error al mover el archivo de la portada
        echo "Error al subir la portada del libro.";
        exit();
    }
} else {
    // Si no se cargó una nueva portada, mantener la ruta de la portada actual en la base de datos
    $nombreUnico = $rutaPortadaActual;
}

    // Preparar la consulta SQL para actualizar los datos del libro
    $sqlDatos = "UPDATE libros SET titulo = ?, autor = ?, sinopsis = ?, ruta_portada = ? WHERE id_libro = ?";
    $stmtDatos = $conn->prepare($sqlDatos);
    $stmtDatos->bind_param("ssssi", $titulo, $autor, $sinopsis, $rutaArchivo, $idLibro); // Cambiar $nombreUnico a $rutaArchivo
    if (!$stmtDatos->execute()) {
        // Si hay un error al actualizar los datos del libro, mostrar el mensaje de error
        echo "Error al actualizar los datos del libro: " . $stmtDatos->error;
        exit();
    }

    // Si todo fue exitoso, mostrar "success"
    echo "success";

    // Cerrar las declaraciones
    $stmtDatos->close();
    if (isset($stmtPortada)) {
        $stmtPortada->close();
    }
} else {
    // Si no se recibieron datos del formulario, mostrar un mensaje de error
    echo "Error: No se recibieron datos del formulario de edición";
}
