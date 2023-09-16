<?php
// Iniciar o continuar la sesión para mantener la sesión y persistencia de datos
session_start();

//Conexión a la base de datos 
include_once 'conexion.php';

$idUsuario = intval($_SESSION['id_user']);
// Consulta para recuperar los datos de la orden, productos y y ordenes de productos
$sql = "SELECT o.id AS orden_id, o.fecha AS fecha, o.total AS total, IF(o.facturada, 'true', 'false') as facturada, p.nombre AS producto_nombre, op.cantidad AS cantidad, p.precio AS precio
        FROM ordenes o
        INNER JOIN ordenes_productos op ON o.id = op.orden_id
        INNER JOIN productos p ON op.producto_id = p.id
        WHERE o.usuario_id = $idUsuario
        ORDER BY orden_id DESC";
$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Recorrer los resultados y almacenar los datos
    while ($row = $result->fetch_assoc()) {
        // Array de ordenes por cliente 
        $ordenes[] = $row;
    }
}

// Se cierra la conexión
$conn->close();

?>