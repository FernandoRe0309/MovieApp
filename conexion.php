<?php
// conexion.php
$host = "localhost";    // En hosting a veces es "localhost" o una IP
$user = "root";         // Tu usuario de BD
$pass = "";             // Tu contraseña de BD
$db   = "streaming_db"; // Nombre de tu BD

$con = new mysqli($host, $user, $pass, $db);

if ($con->connect_error) {
    die("Fallo la conexión: " . $con->connect_error);
}

// Para que los acentos y ñ se vean bien
$con->set_charset("utf8");
?>