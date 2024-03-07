<?php
// Verificar si se enviaron los datos del formulario
if (isset($_POST['id_libro'], $_POST['titulo'], $_POST['autor'], $_POST['sinopsis'])) {
    // Datos de conexión a la base de datos
    $hostname = "roundhouse.proxy.rlwy.net";
    $username = "root";
    $password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
    $database = "railway";
    $dbport = "21765";

    // Crear una conexión a la base de datos
    $conexion = new mysqli($hostname, $username, $password, $database, $dbport);

    // Verificar si hay errores de conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener los datos del formulario
    $id_libro = $_POST['id_libro'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $sinopsis = $_POST['sinopsis'];

    // Preparar la consulta SQL de actualización
    $sql = "UPDATE libros SET titulo = '$titulo', autor = '$autor', sinopsis = '$sinopsis' WHERE id_libro = $id_libro";

    // Ejecutar la consulta SQL
    if ($conexion->query($sql) === TRUE) {
        // La consulta se ejecutó con éxito
        echo "La información del libro se ha actualizado correctamente.";
    } else {
        // Error al ejecutar la consulta
        echo "Error al actualizar el libro: " . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // Si no se enviaron todos los datos del formulario, mostrar un mensaje de error
    echo "Error: Todos los campos del formulario son obligatorios.";
}
