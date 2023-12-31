<?php
session_start();

// Conexión a la base de datos
require_once('../connection/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    // Obtener detalles del producto
    $query = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        // Agregar producto al carrito
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] += 1;
        } else {
            $_SESSION['carrito'][$producto_id] = array(
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'], // Asegúrate de que esta línea está presente
                'precio_unitario' => $producto['precio'],
                'cantidad' => 1
            );            
        }
    }

    $stmt->close();
    $conn->close();

    // Si estás usando AJAX para añadir al carrito, esta línea enviará una respuesta al cliente.
    // Si no, podrías querer redirigir al usuario de vuelta a la página del carrito o mostrar algún mensaje.
    echo json_encode(['status' => 'success', 'message' => 'Producto agregado al carrito']);

    exit;
}
?>
