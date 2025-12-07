<?php
// Datos de conexión (ajustá solo si tu BD tiene otro nombre/clave)
$host    = "localhost";
$bd      = "luzia";   // nombre de tu base de datos
$usuario = "root";    // usuario por defecto de XAMPP
$clave   = "";        // normalmente vacío

try {
    $conn = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $usuario, $clave);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
