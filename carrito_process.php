<?php
// Iniciar o continuar la sesión para mantener el carrito de compras
session_start();

include_once 'conexion.php';

// Consulta para recuperar los datos de la tabla productos
$sql = "SELECT id, nombre, precio FROM productos";
$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Recorrer los resultados y mostrar los datos
    while ($row = $result->fetch_assoc()) {
        // Array de productos 
        $productos[] = $row;
    }
} else {
    echo "No se encontraron resultados en la tabla productos.";
}

// Cerrar la conexión
$conn->close();

// Función para agregar un producto al carrito
function agregarAlCarrito($productoId) {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $productoId) {
            $item['cantidad']++;
            return;
        }
    }

    // Si el producto no está en el carrito, se agrega la sesion
    $producto = obtenerProductoPorId($productoId);
    if ($producto) {
        $producto['cantidad'] = 1;
        $_SESSION['carrito'][] = $producto;
    }
}

// Función para obtener un producto por su id
function obtenerProductoPorId($productoId) {
    global $productos;
    foreach ($productos as $producto) {
        if ($producto['id'] == $productoId) {
            return $producto;
        }
    }
    return null;
}

// Manejar la solicitud de agregar un producto al carrito
if (isset($_POST['agregar_al_carrito'])) {
    $productoId = $_POST['producto_id'];
    agregarAlCarrito($productoId);
    $mensaje = "El producto con ID $productoId se ha agregado al carrito.";
}
// Se muestra mensaje en caso de encontrarse variable $mensaje seteada
if (isset($mensaje)) {
    echo "<div>$mensaje</div>";
}

// Función para eliminar un producto del carrito por su ID
if (isset($_POST['eliminar_producto'])) {
    $productoId = $_POST['eliminar_producto'];
    
    // Buscar el índice del producto en el carrito
    $indice = -1;
    foreach ($_SESSION['carrito'] as $key => $item) {
        if ($item['id'] == $productoId) {
            $indice = $key;
            break;
        }
    }

    // Si se encontró el producto en el carrito, eliminarlo
    if ($indice !== -1) {
        unset($_SESSION['carrito'][$indice]);
        // Redirigir de nuevo a la página del carrito o mostrar un mensaje
        header("Location: carrito.php");
        exit();
    }
}


?>

