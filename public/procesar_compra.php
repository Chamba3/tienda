<?php
session_start();
require_once('../connection/db.php');

// Preparar el detalle de la compra para el correo
$detalleCompra = "Detalle de su Compra:\n";
$total = 0;

// Procesar cada producto en el carrito
foreach ($_SESSION['carrito'] as $producto_id => $producto) {
    // Obtener el stock actual del producto
    $query = "SELECT stock, precio, nombre FROM productos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stock_actual = $row['stock'];
    $precio_unitario = $row['precio'];
    $nombre_producto = $row['nombre'];

    // Verificar si hay suficiente stock
    if ($stock_actual < $producto['cantidad']) {
        echo "No hay suficiente stock para el producto " . $nombre_producto;
        exit; // O manejarlo de otra manera, como redirigir al carrito
    }

    // Disminuir el stock
    $nuevo_stock = $stock_actual - $producto['cantidad'];
    $query = "UPDATE productos SET stock = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $nuevo_stock, $producto_id);
    $stmt->execute();

    // Agregar al detalle de la compra
    $subtotal = $producto['cantidad'] * $precio_unitario;
    $detalleCompra .= $nombre_producto . " x " . $producto['cantidad'] . " = $" . $subtotal . "\n";
    $total += $subtotal;
}

// Limpiar el carrito
$_SESSION['carrito'] = array();

// Enviar el correo electrónico con el detalle de la compra
$emailCliente = 'correo_del_cliente@example.com'; // Reemplaza con el correo del cliente
$asunto = 'Detalle de su Compra en Nuestra Tienda';
$detalleCompra .= "Total: $" . $total . "\n"; // Agregar el total al detalle
$cabeceras = 'From: tu_correo@example.com' . "\r\n" .
             'Reply-To: tu_correo@example.com' . "\r\n" .
             'X-Mailer: PHP/' . phpversion();

mail($emailCliente, $asunto, $detalleCompra, $cabeceras);

// Redirigir al usuario a una página de confirmación
header('Location: confirmacion_compra.php');
exit;

$stmt->close();
$conn->close();
?>
