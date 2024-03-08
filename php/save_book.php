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
    isset($_SESSION['username']) &&
    isset($_FILES['portada']) // Verificar si el campo de carga de archivos está presente
) {
    // Verificar si no hay errores en la carga del archivo
    if ($_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        // Obtener los datos del formulario
        $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
        $autor = mysqli_real_escape_string($conn, $_POST['autor']);
        $sinopsis = mysqli_real_escape_string($conn, $_POST['sinopsis']);
        $username = $_SESSION['username'];

        // Obtener el nombre del archivo cargado
        $nombreArchivo = $_FILES['portada']['name'];

        // Generar un nombre único para el archivo de la portada
        $nombreUnico = uniqid() . '.png';
        $rutaPortada = '../php/portada_libros/' . $nombreUnico;

        // Mover el archivo cargado a la ubicación adecuada en el servidor
        if (move_uploaded_file($_FILES['portada']['tmp_name'], $rutaPortada)) {

            // Insertar los datos del libro junto con la ruta de la portada en la base de datos
            $query = "INSERT INTO libros (titulo, autor, sinopsis, username, imagen_portada, ruta_portada) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", $titulo, $autor, $sinopsis, $username, $nombreArchivo, $rutaPortada);

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
            // Error al mover el archivo
            echo "Error al mover el archivo.";
        }
    } else {
        // Error en la carga del archivo
        echo "Error al cargar la imagen.";
    }
} else {
    // Si los datos del formulario o de la sesión no están presentes, muestra un mensaje de error
    echo "Error: Los datos del formulario o de la sesión están incompletos.";
}
