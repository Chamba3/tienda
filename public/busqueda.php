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

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - Tienda en Línea</title>
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    

<div class="header">
    <img src="../images/logo.png" alt="imagen">
    <form action="busqueda.php" method="GET">
        <input type="text" name="buscar" placeholder="Buscar productos..." value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">
        <input type="submit" value="Buscar">
    </form>
    <a class="logout-link" href="logout.php">cerrar sesión</a>
</div>

<a href="catalogo.php" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver al Catálogo
    </a>
<div class="catalogo-container">
    <?php
    require_once('../connection/db.php');

    if(isset($_GET['buscar']) && !empty($_GET['buscar'])) {
        $busqueda = $conn->real_escape_string($_GET['buscar']);
        $query = "SELECT * FROM productos WHERE nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
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
            }
        } else {
            echo "No sé encontraron resultados de tu busqueda'" . $busqueda . "'.";
        }
    } else {
        echo "Por favor, ingresa una palabra clave para buscar.";
    }

    $conn->close();
    ?>
</div>
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
<!-- Aquí puedes agregar el footer, similar al de tu archivo anterior -->
    <a href="carrito.php" class="carrito-btn">
        <i class="fas fa-shopping-cart"></i>
        <span class="carrito-cantidad"><?php echo array_sum(array_column($_SESSION['carrito'], 'cantidad')); ?></span>
    </a>
</body>
</html>
