<?php
session_start();

// Verifica si el ID del producto está establecido y si el producto está en el carrito
if (isset($_GET['id']) && isset($_SESSION['carrito'][$_GET['id']]) && isset($_GET['cantidad'])) {
    $producto_id = $_GET['id'];
    $cantidad_a_eliminar = intval($_GET['cantidad']);

    // Resta la cantidad especificada del producto en el carrito
    $_SESSION['carrito'][$producto_id]['cantidad'] -= $cantidad_a_eliminar;

    // Si la cantidad resultante es 0 o menor, elimina el producto del carrito
    if ($_SESSION['carrito'][$producto_id]['cantidad'] <= 0) {
        unset($_SESSION['carrito'][$producto_id]);
    }

    // Redirige al usuario de vuelta al carrito con un mensaje de éxito
    header('Location: carrito.php?mensaje=Producto eliminado con éxito.');
    exit;
} else {
    // Si el ID del producto no está establecido o el producto no está en el carrito, redirige con un mensaje de error
    header('Location: carrito.php?mensaje=Error al eliminar el producto.');
    exit;
}
?>
