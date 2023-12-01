<?php
require_once('../connection/db.php');
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    $product_id = $conn->real_escape_string($_GET['id']);

    // Usa el nombre correcto de la columna. Cambia 'id' si el nombre de tu columna es diferente
    $query = "SELECT * FROM productos WHERE id = '$product_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Continúa con el procesamiento...
        if (isset($product['id_categoria'])) {
            $category_id = $product['id_categoria'];

            if ($category_id !== null) {
                $relatedQuery = "SELECT * FROM productos WHERE id_categoria = '$category_id' AND id != '$product_id' LIMIT 2";
                $relatedResult = $conn->query($relatedQuery);

                if ($relatedResult->num_rows > 0) {
                    $related_products = $relatedResult->fetch_all(MYSQLI_ASSOC);
                }
            }
        }
    } else {
        echo "Producto no encontrado.";
    }
} else {
    echo "ID de producto no especificado.";
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" type="text/css" href="../css/detalle_producto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.add-to-cart-btn').click(function(e) {
            e.preventDefault();

            var productoId = $(this).data('id');

            $.post('agregar_al_carrito.php', { producto_id: productoId }, function(response) {
    // Incrementa la cantidad mostrada en la tarjeta del producto
    var cantidadElemento = $("#cantidad-" + productoId);
    var cantidadActual = parseInt(cantidadElemento.text()) || 0;
    cantidadElemento.text(cantidadActual + 1);

    // Actualizar el número de productos en el carrito
    var carritoElemento = $(".carrito-cantidad");
    var cantidadCarrito = parseInt(carritoElemento.text()) || 0;
    carritoElemento.text(cantidadCarrito + 1);
});
        });
    });
    </script>
</head>
<body>
    
    <div class="header">
        <img src="../images/logo.png" alt="imagen">
        <form action="../public/busqueda.php" method="GET">
            <input type="text" name="buscar" placeholder="Buscar productos...">
            <input type="submit" value="Buscar">
        </form>
    </div>

    <a href="catalogo.php" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver al Catálogo
    </a>
</div>
<div class="content-wrapper">
    <div class="product-detail-container">
        <?php if (isset($product)) { ?>
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($product['url']); ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>">
            </div>
            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['nombre']); ?></h1>
                <p><?php echo htmlspecialchars($product['info']); ?></p>
                <p>Precio: $<?php echo htmlspecialchars($product['precio']); ?></p>
                <button class="add-to-cart-btn" data-id="<?php echo htmlspecialchars($product['id']); ?>">Agregar al carrito</button>
            </div>
    <?php } else {
        echo "Producto no encontrado.";
    } ?>
    </div>
</div>
<div class="related-products-container">
    <h2>Productos Relacionados</h2>
    <?php
    if (isset($related_products)) {
        foreach ($related_products as $related) {
            echo "<div class='related-product'>";
            echo "<div class='producto-card'>";
            echo "<img src='" . htmlspecialchars($related['url']) . "' alt='" . htmlspecialchars($related['nombre']) . "' class='related-product-image'>";
            echo "<h3>" . htmlspecialchars($related['nombre']) . "</h3>";
            echo "<p>" . htmlspecialchars($related['descripcion']) . "</p>";
            echo "<p>Precio: $" . htmlspecialchars($related['precio']) . "</p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay productos relacionados.</p>";
    }
    ?>
</div>

    <a href="carrito.php" class="carrito-btn">
        <i class="fas fa-shopping-cart"></i>
        <span class="carrito-cantidad"><?php echo array_sum(array_column($_SESSION['carrito'], 'cantidad')); ?></span>
    </a>
    
    <footer>
        <div class="footer-content">
            <p>&copy; 2023 PhoneGear. Todos los derechos reservados.</p>
            <div class="social-icons">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
            </div>
            <p>Contacto: PhoneGear@gmail.com</p>
        </div>
    </footer>
</body>
</html>
