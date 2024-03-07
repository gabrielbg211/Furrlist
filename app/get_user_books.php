<?php
// app/get_user_books.php

// Verificar si el parámetro GET "username" está presente
if (isset($_GET['username'])) {
    // Si está presente, asignarlo a una variable
    $username = $_GET['username'];

    // Conexión a la base de datos
    require_once('conexion.php');

    // Obtener el ID del usuario
    $query = "SELECT user_id FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        die("Usuario no encontrado");
    }
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];

    // Obtener los libros del usuario actual
    $query = "SELECT * FROM libros WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generar el HTML para los libros del usuario actual
    $html = '';
    while ($row = $result->fetch_assoc()) {
        $html .= '<div class="libro">';
        $html .= '<h3>' . $row['titulo'] . '</h3>';
        $html .= '<h4>' . $row['autor'] . '</h4>';
        $html .= '<p>' . $row['sinopsis'] . '</p>';
        $html .= '</div>';
    }

    echo $html;

    $stmt->close();
    $conn->close();
} else {
    // Si el parámetro GET "username" no está presente, mostrar un mensaje de error
    echo "El parámetro 'username' no está presente en la solicitud GET.";
}
