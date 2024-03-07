<?php
session_start();

$DB_HOST =$getenv('DB_HOST');
$DB_USER =$getenv('DB_USER');
$DB_PASSWORD =$getenv('DB_PASSWORD');
$DB_NAME =$getenv('DB_NAME');
$DB_PORT =$getenv('DB_PORT');

// Crear la conexión a la base de datos
$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $DB_PORT);