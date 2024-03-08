<?php
require_once('conexion_1.php');

// Verificar si la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si los datos del formulario y de la sesión están presentes
if (
    isset($_POST['titulo']) && 
    isset($_POST['autor']) && 
    isset($_POST['sinopsis']) && 
    isset($_SESSION['username'])
) {
    // Obtener los datos del formulario
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $autor = mysqli_real_escape_string($conn, $_POST['autor']);
    $sinopsis = mysqli_real_escape_string($conn, $_POST['sinopsis']);
    $username = $_SESSION['username'];

    // Insertar los datos del libro en la base de datos
    $query = "INSERT INTO libros (titulo, autor, sinopsis, username) 
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $titulo, $autor, $sinopsis, $username);

    // Ejecutar la consulta preparada
    if ($stmt->execute()) {
        // Si la consulta se ejecuta con éxito, devolver "success"
        echo "success";
    } else {
        // Si hay un error en la consulta, devolver el mensaje de error
        echo "Error al actualizar el libro: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    // Si los datos del formulario o de la sesión no están presentes, muestra un mensaje de error
    echo "Error: Los datos del formulario o de la sesión están incompletos.";
}
