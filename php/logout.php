<?php

header("Access-Control-Allow-Origin: http://192.168.1.10:8080");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
// Iniciar sesión si aún no está iniciada
session_start();

// Destruir la sesión actual
session_destroy();

// Responder con éxito
echo "logout_success";
