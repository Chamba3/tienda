<?php
session_start();
require_once('../connection/db.php');

foreach ($_SESSION['carrito'] as $producto_id => $producto) {
    // Obtener el stock actual del producto
    $query = "SELECT stock FROM productos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stock_actual = $row['stock'];

    // Verificar si hay suficiente stock
    if ($stock_actual < $producto['cantidad']) {
        echo "No hay suficiente stock para el producto " . $producto['nombre'];
        exit; // O manejarlo de otra manera, como redirigir al carrito
    }

    // Disminuir el stock
    $nuevo_stock = $stock_actual - $producto['cantidad'];
    $query = "UPDATE productos SET stock = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $nuevo_stock, $producto_id);
    $stmt->execute();
}

$_SESSION['carrito'] = array();

// Redirigir al usuario a una página de confirmación o al catálogo
header('Location: confirmacion_compra.php'); // Cambia 'confirmacion_compra.php' por la página que desees
exit;

$stmt->close();
$conn->close();
?>