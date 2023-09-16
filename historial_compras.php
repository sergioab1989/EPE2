<?php
// Incluye el archivo historial_process.php para persistencia de datos de sesión, ademas, se redirecciona al index en caso de que no haya iniciada sesión de usuario
include 'historial_process.php';
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tienda de Celulares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">Tienda Celulares</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <?php
                            // Se valida si el usuario posee sesión iniciada
                            if (isset($_SESSION['username'])) {
                                echo '<li class="nav-item"><a class="nav-link" href="#">Bienvenido, ' . $_SESSION['username'] . '</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="carrito.php">Ir a Carrito</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>';
                            } else {
                                echo '<li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>';
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <div class="container">
    <h1 class="my-4">Historial de Órdenes</h1>
        <?php
        if (isset($ordenes) && count($ordenes) > 0) {
            $prevOrderId = null;  // Variable para almacenar el número de orden previo
                
            foreach ($ordenes as $orden) {
                $currentOrderId = $orden['orden_id'];

                // Si el número de orden cambia, se muestra un encabezado para la nueva orden ademas se muestra el total de la orden y si esta facturada
                if ($currentOrderId !== $prevOrderId) {
                    echo '<h3>Número de Orden: ' . $currentOrderId . '</h3>';
                    echo '<h4>Total orden: $' . number_format($orden["total"]) . '</h4>';
                    if ($orden["facturada"]) {
                        echo '<h4>Facturada: Si</h4>';
                    } else {
                        echo '<h4>Facturada: No</h4>';
                    }
                    $prevOrderId = $currentOrderId;
                }

                // Se muestra el detalle de la orden (productos, cantidad, precio por cantidad de productos.)
                echo '<ul class="list-group">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Producto: ' . $orden['producto_nombre'] . '
                                </div>
                                <div class="col-md-3">
                                    Cantidad: ' . $orden['cantidad'] . '
                                </div>
                                <div class="col-md-3">
                                    Precio: $' . number_format($orden['precio']*$orden['cantidad']) . '
                                </div>
                            </div>
                        </li>
                    </ul>';
            }
        } else {
            echo '<p>No existen ordenes disponibles.</p>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>