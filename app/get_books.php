<?php
// Datos de conexión a la base de datos
$hostname = "roundhouse.proxy.rlwy.net";
$username = "root";
$password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";
$database_url = "mysql://root:FfgBbhdC14-d3g5DDA6F5fec43cHBf3f@mysql.railway.internal:3306/railway";

// Conexión a la base de datos
$conexion  = new mysqli($hostname, $username, $password, $database, $dbport, $database_url);


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM libros";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    // Crear un array para almacenar los libros
    $libros = array();

    // Iterar sobre los resultados y agregarlos al array
    while ($fila = $resultado->fetch_assoc()) {
        $libros[] = $fila;
    }

    // Devolver los libros en formato JSON
    echo json_encode($libros);
} else {
    // No se encontraron libros en la base de datos
    echo "No se encontraron libros en la base de datos.";
}

// Cerrar la conexión
$conexion->close();
