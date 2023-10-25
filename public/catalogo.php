<!DOCTYPE html>
<html>
<head>
<div class="header">
<img src="../images/logo.png" alt="imagen">
    <a class="logout-link" href="logout.php">cerrar sesión</a>
</div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda en Línea - Catálogo de Productos</title>
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
</head>

<body>
    <div class="catalogo-container">
        <?php
        // Realiza una consulta a la base de datos para obtener la lista de productos
        require_once('../connection/db.php');

        $query = "SELECT * FROM productos";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Muestra cada producto en una tarjeta
                echo "<div class='producto-card'>";
                echo '<img src="' . $row['url'] . '" alt="' . $row['nombre'] . '">';
                echo "<h2>" . $row['nombre'] . "</h2>";
                echo "<p>" . $row['descripcion'] . "</p>";
                echo "<p>Precio: $" . $row['precio'] . "</p>";
                echo "<p>Stock Disponible: " . $row['stock'] . "</p>";
                echo "<button>Agregar al Carrito</button>";
                echo "</div>";
            }
        } else {
            echo "No hay productos disponibles en el catálogo.";
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

