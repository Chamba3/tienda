<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Detalles del Producto</title>
    <!-- Agrega enlaces a tus archivos CSS y otros recursos aquí -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php
    // Verifica si se ha proporcionado un ID de producto válido
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Obtiene el ID del producto desde la URL
        $producto_id = $_GET['id'];

        // Realiza una consulta a la base de datos para obtener información del producto
        require_once('includes/db.php');

        $query = "SELECT * FROM productos WHERE id = $producto_id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Muestra la información detallada del producto
            echo "<h1>Detalles del Producto</h1>";
            echo "<img src='images/" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>";
            echo "<h2>" . $row['nombre'] . "</h2>";
            echo "<p>" . $row['descripcion'] . "</p>";
            echo "<p>Precio: $" . $row['precio'] . "</p>";
            echo "<p>Stock Disponible: " . $row['stock'] . "</p>";
            echo "<button>Agregar al Carrito</button>";
        } else {
            echo "Producto no encontrado.";
        }

        $conn->close();
    } else {
        echo "ID de producto no válido.";
    }
    ?>
</body>
</html>
