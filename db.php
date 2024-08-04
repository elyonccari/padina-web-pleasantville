<?php
$servername = "localhost";
$username = "leoncito";
$password = "Elyon123";
$dbname = "PleasantvilleTheatre";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
