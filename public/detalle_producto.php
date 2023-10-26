<?php
require_once('../connection/db.php');
$product_id = $_GET['id'];
$query = "SELECT * FROM productos WHERE id = $product_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" type="text/css" href="../css/detalle_producto.css">
</head>
<body>
    <div class="header">
        <img src="../images/logo.png" alt="imagen">
        
        <!-- Formulario de búsqueda -->
        <form action="../public/busqueda.php" method="GET">
            <input type="text" name="buscar" placeholder="Buscar productos...">
            <input type="submit" value="Buscar">
        </form>
        <a href="catalogo.php" class="return-link">Volver al catálogo</a>
    </div>
    
    <div class="product-detail-container">
        <?php
        if (isset($product)) {
        ?>
            <div class="product-image">
                <img src="<?php echo $product['url']; ?>" alt="<?php echo $product['nombre']; ?>">
            </div>
            <div class="product-info">
                <h1><?php echo $product['nombre']; ?></h1>
                <p><?php echo $product['descripcion']; ?></p>
                <p>Precio: $<?php echo $product['precio']; ?></p>
                <button>Agregar al carrito</button>
            </div>
        <?php
        } else {
            echo "Producto no encontrado.";
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
    </footer>
</body>
</html>



