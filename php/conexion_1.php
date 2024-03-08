<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Access-Control-Allow-Origin: http://192.168.1.10:8080");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");


// Datos de conexión a la base de datos
$hostname = "roundhouse.proxy.rlwy.net";
$username = "root";
$password = "FfgBbhdC14-d3g5DDA6F5fec43cHBf3f";
$database = "railway";
$dbport = "21765";
$database_url = "mysql://root:FfgBbhdC14-d3g5DDA6F5fec43cHBf3f@mysql.railway.internal:3306/railway";

// Conexión a la base de datos
$conn = new mysqli($hostname, $username, $password, $database, $dbport, $database_url);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

