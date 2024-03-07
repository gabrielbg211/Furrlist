<?php
// Inicia la sesión
session_start();

// Verifica si el usuario está autenticado en la base de datos
if (isset($_SESSION['username'])) {
    // El usuario está autenticado en la base de datos
    echo "Autenticado";
} else {
    // El usuario no está autenticado en la base de datos
    echo "No autenticado";
}