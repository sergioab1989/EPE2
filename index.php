<?php
// Incluye el archivo carrito.php
include 'carrito_process.php';
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
                            // Se valida si el usuario está autenticado
                            if (isset($_SESSION['username'])) {
                                echo '<li class="nav-item"><a class="nav-link" href="#">Bienvenido, ' . $_SESSION['username'] . '</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="carrito.php">Ir a Carrito</a></li>';
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

    <h1>Tienda de Celulares</h1>
    
    <!-- Lista de productos -->
    <div class="container">
        <h1 class="my-4">Productos</h1>
        <ul class="list-group">
            <?php foreach ($productos as $producto): ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $producto['nombre']; ?>
                        </div>
                        <div class="col-md-3">
                            Precio: $<?php echo number_format($producto['precio']); ?>
                        </div>
                    </div>
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                <img src="../src/<?php echo $producto['id']; ?>.jpg" class="d-block mx-auto w-25" alt="Imagen del Producto">
                                <?php if (isset($_SESSION['username'])): ?>
                                    <button type="submit" name="agregar_al_carrito" class="btn btn-primary">Agregar al carrito</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>