<?php
// Iniciar la sesión si no está iniciada
session_start();

// Eliminar todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio de sesión u otra página
// Dependiendo de la lógica de tu aplicación
// En este caso, simplemente respondemos con un mensaje de éxito
echo "Sesión cerrada exitosamente.";
