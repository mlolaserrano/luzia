<?php
session_start();      // 1. Inicia la sesión
session_unset();      // 2. Elimina todas las variables de la sesión
session_destroy();    // 3. Destruye la sesión
header("Location: admi_login.html"); // Redirige a la página de login
exit;
?>