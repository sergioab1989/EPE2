<?php
session_start();

// Se valida si se ha enviado el formulario para finalizar la compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Conexión a la base de datos
    require_once 'conexion.php';

    //Seteo de variable en 0
    $totalCarrito = 0;

    //Obtención de total de compra
    foreach ($_SESSION['carrito'] as $item) {
        $subtotal = $item['cantidad'] * $item['precio'];
        $totalCarrito += $subtotal;
    }

    //Obtención de variable id de usuario y se crea sentencia insert con datos de orden
    $idUsuario = intval($_SESSION['id_user']);
    $sql_orden = "INSERT INTO ordenes (usuario_id, total, facturada) VALUES ($idUsuario, $totalCarrito, 'true')";
    
    //Se ejecuta query sql de insert y se valida si se ejecuto, en caso de que se hayan almacenado los datos correctamente 
    if ($conn->query($sql_orden) === TRUE) {
        
        //Se genera detalle de orden de compra
        $orden = "=== Orden de Compra ===\n";
        $orden .= "Fecha: " . date("Y-m-d H:i:s") . "\n\n";
    
        $orden_id = $conn->insert_id;

        //Foreach para iterar productos de carrito de compra
        foreach ($_SESSION['carrito'] as $item) {

            //obtención y casteo de variables para inserción de datos en tabla ordenes_productos
            $id_prod = intval($item['id']);  
            $cant_prod = doubleval($item['cantidad']);  
            $sql_orden_prod = "INSERT INTO ordenes_productos (orden_id, producto_id, cantidad) VALUES ($orden_id, $id_prod, $cant_prod)";
            
            //Se ejecuta query de insert y se valida si se ejecuto, en caso de que se hayan almacenado los datos correctamente 
            if ($conn->query($sql_orden_prod) === TRUE) {

                //Se almacenan datos en variable orden para generar archivo
                $subtotal = $item['cantidad'] * $item['precio'];
        
                $orden .= "Producto: " . $item['nombre'] . "\n";
                $orden .= "Cantidad: " . $item['cantidad'] . "\n";
                $orden .= "Precio Unitario: $" . number_format($item['precio']) . "\n";
                $orden .= "Subtotal: $" . number_format($subtotal) . "\n\n";
            } else {
                // Se cierra conexión en caso de error y se redirige a inicio
                $conn->close();
                echo "Error al insertar datos de venta: " . $conn->error;
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'index.php'; // Redirigir al usuario después de 2 segundos
                        }, 2000); 
                      </script>";
            }    
        }

        //Se cierra conexión a base de datos
        $conn->close();

        $orden .= "Total a Pagar: $" . number_format($totalCarrito) . "\n";

        // Se guarda la orden en un archivo 
        $nombreArchivo = "orden_" . date("YmdHis") . ".txt";
        file_put_contents($nombreArchivo, $orden);
    
        // Se almacena el nombre del archivo en una variable de sesión
        $_SESSION['nombre_orden'] = $nombreArchivo;
    
        // Se limpia el carrito después de finalizar la compra
        unset($_SESSION['carrito']);
    
        
        // Se redirige al usuario a una página de confirmación
        header("Location: confirmacion.php");        
        exit();

    } else {
        // Se cierra conexión en caso de error
        $conn->close();
        echo "Error al insertar datos de venta: " . $conn->error;
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php'; // Redirigir al usuario después de 2 segundos
                }, 2000); 
              </script>";
    }
} else {
    // Si alguien intenta acceder directamente a este archivo sin enviar el formulario, redirige a la página de inicio
    header("Location: index.php");
    exit();
}
?>