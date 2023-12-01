<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}
?>

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

<?php $categoriaActiva = 'catalogo'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda en Línea - Catálogo de Productos</title>
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
</head>
<body>
    <div class="header">
        <div class="img-logo">
            <img src="../images/logo.png" alt="imagen">
        </div>
        <form action="../public/busqueda.php" method="GET">
            <input type="text" name="buscar" placeholder="Buscar productos...">
            <input type="submit" value="Buscar">
        </form>
        <a href="logout.php" class="logout-link">
            <i class="fa fa-sign-out-alt"></i> <!-- Ícono de FontAwesome -->
        </a>
    </div>

    <div class="toolbar">
        <a href="catalogo.php" class="toolbar-btn <?php echo ($categoriaActiva == 'catalogo') ? 'active' : ''; ?>">Catalogo</a>
        <a href="categoria_telefonos.php" class="toolbar-btn <?php echo ($categoriaActiva == 'telefonos') ? 'active' : ''; ?>">Teléfonos</a>
        <a href="categoria_fundas.php" class="toolbar-btn <?php echo ($categoriaActiva == 'fundas') ? 'active' : ''; ?>">Fundas</a>
        <a href="categoria_cargadores.php" class="toolbar-btn <?php echo ($categoriaActiva == 'cargadores') ? 'active' : ''; ?>">Cargadores</a>
        <a href="categoria_cables.php" class="toolbar-btn <?php echo ($categoriaActiva == 'cables') ? 'active' : ''; ?>">Cables</a>
        <a href="categoria_auriculares.php" class="toolbar-btn <?php echo ($categoriaActiva == 'auriculares') ? 'active' : ''; ?>">Auriculares</a>
    </div>

    <div class="catalogo-container">
        <?php
        require_once('../connection/db.php');

        $query = "SELECT * FROM productos";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productoEnCarrito = isset($_SESSION['carrito'][$row['id']]) ? $_SESSION['carrito'][$row['id']]['cantidad'] : 0;
                
                echo "<a href='detalle_producto.php?id=" . $row['id'] . "' class='producto-link'>";
                echo "<div class='producto-card'>";
                echo '<img src="' . $row['url'] . '" alt="' . $row['nombre'] . '">';
                echo "<h2>" . $row['nombre'] . "</h2>";
                echo "<p>" . $row['descripcion'] . "</p>";
                echo "<p>Precio: $" . $row['precio'] . "</p>";
                echo "<p>Stock Disponible: " . $row['stock'] . "</p>";
                if ($productoEnCarrito >= 0) { 
                    echo "<span class='producto-cantidad' id='cantidad-" . $row['id'] . "'>" . $productoEnCarrito . "</span>";
                }
                echo "<button class='add-to-cart-btn' data-id='" . $row['id'] . "'>Agregar al Carrito</button>";
                echo "</div>";
                echo "</a>";
            }
        } else {
            echo "No hay productos disponibles en el catálogo.";
        }

        $conn->close();
        ?>
           <a href="carrito.php" class="carrito-btn">
        <i class="fas fa-shopping-cart"></i>
        <span class="carrito-cantidad"><?php echo array_sum(array_column($_SESSION['carrito'], 'cantidad')); ?></span>
    </a>

    </div>
    <footer>
        <div class="footer-content">
            <p>&copy; 2023 PhoneGear. Todos los derechos reservados.</p>
            <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p>Contacto: PhoneGear@gmail.com</p>
        </div>
    </footer>
</body>
</html>
