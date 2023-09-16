<?php
// Datos para conexión a la base de datos mysql 
$servername = "127.0.0.1";
$username_db = "root";
$password_db = "";
$database = "db_tienda";

$conn = new mysqli($servername, $username_db, $password_db, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>