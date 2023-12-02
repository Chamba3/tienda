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
        <div class="img-logo">
            <img src="../images/logo.png" alt="imagen">
        </div>

    <!-- Right part with user info, logout, and search -->
    <div class="header-right">
        <!-- User info and logout link container -->
        <div class="user-logout-container">
            <?php if(isset($_SESSION['usuario_nombre'])): ?>
                <div class="user-info">
                    <i class="fa fa-user"></i>
                    <span><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
                </div>
            <?php endif; ?>
            <!-- Logout -->
        <a href="logout.php" class="logout-link">
            <i class="fa fa-sign-out-alt"></i> <!-- Ícono de FontAwesome -->
        </a>
        </div>
        
        <!-- Search form -->
        <form action="../public/busqueda.php" method="GET" class="search-form">
            <input type="text" name="buscar" placeholder="Buscar productos...">
            <input type="submit" value="Buscar">
        </form>
    </div>
</div>

    <a href="catalogo.php" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver al Catálogo
    </a>
</div>

<div class="content-wrapper">
    <!-- Contenedor de Detalles del Producto -->
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
        <?php } else { ?>
            <p>Producto no encontrado.</p>
        <?php } ?>
    </div>

    <!-- Contenedor de Productos Relacionados -->
    <div class="related-products-container">
    <h2>Productos Relacionados</h2>
    <div class="cards-container"> <!-- Contenedor para todas las tarjetas -->
        <?php if (isset($related_products)) { ?>
            <?php foreach ($related_products as $related) { ?>
                <div class='producto-card'>
                    <img src="<?php echo htmlspecialchars($related['url']); ?>" alt="<?php echo htmlspecialchars($related['nombre']); ?>" class='related-product-image'>
                    <h3><?php echo htmlspecialchars($related['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($related['descripcion']); ?></p>
                    <p>Precio: $<?php echo htmlspecialchars($related['precio']); ?></p>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No hay productos relacionados.</p>
        <?php } ?>
    </div> 
    <a href="carrito.php" class="carrito-btn">
        <i class="fas fa-shopping-cart"></i>
        <span class="carrito-cantidad"><?php echo array_sum(array_column($_SESSION['carrito'], 'cantidad')); ?></span>
    </a>
</div>

</div>
    
<footer>
        <div class="footer-content">
            <p>&copy; 2023 PhoneGear. Todos los derechos reservados.</p>
            <div class="social-icons">
            <a href="https://www.facebook.com/profile.php?id=61553923086966&locale=es_LA"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/phonegearsv/"><i class="fab fa-instagram"></i></a>
            </div>
            <p>Contacto: PhoneGear@gmail.com</p>
        </div>
    </footer>
</body>
</html>
