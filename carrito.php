<?php
// Se incluye archivo carrito_process.php para persistencia de datos y funciones. Ademas se redirecciona al index si no hay sesion iniciada
include 'carrito_process.php';
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tienda de Celulares - Carrito</title>
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
                            // Verifica si el usuario está autenticado
                            if (isset($_SESSION['username'])) {
                                echo '<li class="nav-item"><a class="nav-link" href="#">Bienvenido, ' . $_SESSION['username'] . '</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="historial_compras.php">Historial de Compras</a></li>';
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
    <h1>Carrito de compras</h1>
    <!-- Carrito de compras -->
    <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0): ?>
        <ul>
            <?php foreach ($_SESSION['carrito'] as $item): ?>
                <li>
                    <?php echo $item['nombre']; ?> - Cantidad: <?php echo $item['cantidad']; ?>
                    <!-- Muestra el precio del producto -->
                    Precio Unitario: $<?php echo number_format($item['precio']); ?>
                    <!-- Muestra el total por los productos añadidos -->
                    Total: $<?php echo number_format($item['cantidad'] * $item['precio']); ?>
                    <!-- Boton para eliminar productos del carrito -->
                    <form method="POST" action="carrito_process.php">
                        <input type="hidden" name="eliminar_producto" value="<?php echo $item['id']; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>El carrito de compras está vacío.</p>
    <?php endif; ?>

    <?php
    $totalCarrito = 0; // Inicializa el total del carrito a 0

    // Verifica si el carrito está vacío o no está definido
    if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
        foreach ($_SESSION['carrito'] as $item) {
            // Se calcula el total por producto y agrégalo al total del carrito
            $totalProducto = $item['cantidad'] * $item['precio'];
            $totalCarrito += $totalProducto;
        }
        echo '<h2>Total a pagar: $' . number_format($totalCarrito) . '</h2>';
        // Se piden datos de transferencia para procesar la Orden
        echo '<form method="POST" action="finaliza_compra.php">
                <div class="form-group">
                    <label for="numero_transferencia">Número de Transferencia</label>
                    <input type="number" class="form-control" id="numero_transferencia" name="numero_transferencia" required>
                </div>
                <div class="form-group">
                    <label for="nombre_persona_pago">Nombre de la Persona que hizo el pago</label>
                    <input type="text" class="form-control" id="nombre_persona_pago" name="nombre_persona_pago" required>
                </div>
                <br>
                <button type="submit" class="btn btn-success">Finalizar Compra</button>
             </form>';
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>