<?php
session_start();

// Conexión a la base de datos
require_once('conexion.php');

// se reciben los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Se realiza la consulta en la base de datos
$sql = "SELECT id, username, password FROM usuarios WHERE username = '$username'";
$result = $conn->query($sql);

// Se valida si el resultado de la consulta a la base de datos posee un resultado
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Se valida si la contraseña es correcta
    if (password_verify($password, $row["password"])) {
        // Se muestra en pantalla incio de sesión exitoso, se almacenan los datos del usuario en sesion y redirecciona al index
        echo "Inicio de sesión exitoso. ¡Bienvenido, " . $row["username"] . "!"; 
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $row["id"];
        echo "<script>
        setTimeout(function() {
            window.location.href = 'index.php'; // Redirigir al usuario después de 2 segundos
        }, 3000); 
     </script>";
    } else {
        // En caso de que contraseña no sea correcta se muestra en pantalla y se redirecciona a la pagina de login
        echo "La contraseña es incorrecta. Por favor, inténtelo de nuevo.";
        echo "<script>
        setTimeout(function() {
            window.location.href = 'login.php'; // Redirigir al usuario después de 2 segundos
        }, 2000); 
     </script>";
    }
} else {
    //en caso de no encontrar a usuario se dan opciones para registro, ir a login o volver a pagina principal
    echo "Usuario no encontrado. Por favor, regístrese primero.<br>";
    echo "<a href='register.php'>Ir a Registro</a><br>";
    echo "<a href='login.php'> Ir Inicio de Sesion</a><br>";
    echo "<a href='index.php'>Volver a la pagina Principal</a>";
}
// Se cierra conexión con la base de datos
$conn->close();
?>