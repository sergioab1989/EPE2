<?php
//Se destruye sesión de usuario y datos almacenados en sesion
session_start();
session_destroy();
header("Location: index.php"); // Redirige al usuario a la página principal
?>