<?php
// Se valida si se ha enviado el formulario para registrar al usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Se conecta a la base de datos 
    require_once('conexion.php');
    //sentencia select para validar si existe usuario y se ejecuta consulta
    $sql_query = "SELECT id FROM usuarios WHERE username = '$username'";
    $result_query = $conn->query($sql_query);

    //Si existen filas en la consulta, se informa que usuario ya existe 
    if ($result_query->num_rows > 0) {
        echo "Usuario ya existe, favor intentar nuevamente<br>";
        echo "<a href='index.php'>Volver a la pagina principal</a><br>";
        echo "<a href='register.php'>Volver a Registro</a>";
    } else {
        //Validacion de contraseña
        if ($password != $confirm_password) {
            echo "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
        } else {
            // se hashea la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
            // Se inserta el nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$hashed_password')";

            //Se ejecuta query y se valida si fue exitoso.
            if ($conn->query($sql) === TRUE) {
                echo "Registro exitoso. Ahora puedes iniciar sesión. <a href='login.php'> Ir a Iniciar Sesion</a> <br>";
                echo "Volver al Inicio <a href='index.php'>Volver a la pagina principal</a>";
            } else {
                // En caso de error se muestra mensaje en pantalla
                echo "Error al registrar el usuario: " . $conn->error;
                echo "Volver al Inicio <a href='index.php'>Volver a la pagina principal</a>";
            }
        }
    }
    // Se cierra la conexión a la base de datos
    $conn->close();
}
?>