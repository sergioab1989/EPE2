<?php
// Iniciar o continuar la sesión para mantener el carrito de compras y datos persistentes. En caso de no existir sesion activa, se redireciona al index
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Compra Exitosa</h1>
        <p>Gracias por su compra. Aquí está su orden de compra:</p>
        <?php
        // Verifica si se almacenó el nombre del archivo de la orden en la variable de sesión
        if (isset($_SESSION['nombre_orden'])) {
            $nombreorden = $_SESSION['nombre_orden'];
            // Se lee el contenido del archivo de la orden y lo muestra
            $contenidoorden = file_get_contents($nombreorden);
            echo '<pre>' . htmlspecialchars($contenidoorden) . '</pre>';
        } else {
            echo 'No se encontró la orden.';
        }
        ?>
        <p>Favor acercaté a nuestra tienda ubicada en calle Condell 168, comuna y ciudad de Santiago para retirar el o los productos adquiridos</p>
        <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
    </div>
</body>
</html>