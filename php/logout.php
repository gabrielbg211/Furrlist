<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Destruir la sesión actual
session_destroy();

// Responder con éxito
echo "logout_success";
