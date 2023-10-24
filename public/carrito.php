<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Carrito de Compras</title>
    <!-- Agrega enlaces a tus archivos CSS y otros recursos aquí -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>Carrito de Compras</h1>

    <?php
    // Verifica si el carrito de compras del usuario está vacío o no
    $carrito_vacio = true; // Puedes definir esta variable según la lógica de tu carrito

    if (!$carrito_vacio) {
        // Muestra los productos en el carrito
        echo "<table>";
        echo "<tr>";
        echo "<th>Producto</th>";
        echo "<th>Cantidad</th>";
        echo "<th>Precio Unitario</th>";
        echo "<th>Total</th>";
        echo "<th>Eliminar</th>";
        echo "</tr>";

        // Itera a través de los productos en el carrito
        // Debes obtener esta información de tu lógica del carrito
        $productos_carrito = array(
            // Debe contener información sobre los productos en el carrito
        );

        foreach ($productos_carrito as $producto) {
            echo "<tr>";
            echo "<td>" . $producto['nombre'] . "</td>";
            echo "<td>" . $producto['cantidad'] . "</td>";
            echo "<td>$" . $producto['precio_unitario'] . "</td>";
            echo "<td>$" . ($producto['cantidad'] * $producto['precio_unitario']) . "</td>";
            echo "<td><a href='eliminar_del_carrito.php?id=" . $producto['id'] . "'>Eliminar</a></td>";
            echo "</tr>";
        }

        echo "</table>";

        // Calcula el total del carrito
        $total_carrito = 0;
        foreach ($productos_carrito as $producto) {
            $total_carrito += $producto['cantidad'] * $producto['precio_unitario'];
        }

        echo "<p>Total del Carrito: $" . $total_carrito . "</p>";
        echo "<button>Proceder al Pago</button>";
    } else {
        echo "<p>El carrito de compras está vacío.</p>";
    }
    ?>
</body>
</html>
