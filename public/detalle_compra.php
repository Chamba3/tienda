<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Detalle de Compra</title>
    <!-- Agrega enlaces a tus archivos CSS y otros recursos aquí -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>Detalle de Compra</h1>

    <?php
    // Verifica si se ha proporcionado un ID de compra válido
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Obtiene el ID de compra desde la URL
        $compra_id = $_GET['id'];

        // Realiza una consulta a la base de datos para obtener información detallada de la compra
        require_once('includes/db.php');

        // Supongamos que tienes un sistema de autenticación y que el ID del usuario se obtiene desde la sesión
        $usuario_id = 1; // Reemplaza con la lógica para obtener el ID del usuario autenticado

        $query = "SELECT compras.id, compras.fecha, compras.total
                  FROM compras
                  WHERE compras.cliente_id = $usuario_id AND compras.id = $compra_id";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Muestra la información detallada de la compra
            $fecha_compra = $row['fecha'];
            $total_compra = $row['total'];

            echo "<p>Fecha de Compra: $fecha_compra</p>";
            echo "<p>Total de Compra: $$total_compra</p>";

            // Consulta los detalles de la compra
            $query_detalles = "SELECT detalles_compra.producto_id, productos.nombre, detalles_compra.cantidad, detalles_compra.precio_unitario
                              FROM detalles_compra
                              INNER JOIN productos ON detalles_compra.producto_id = productos.id
                              WHERE detalles_compra.compra_id = $compra_id";

            $result_detalles = $conn->query($query_detalles);

            if ($result_detalles->num_rows > 0) {
                echo "<h2>Detalles de la Compra</h2>";
                echo "<table>";
                echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Total</th></tr>";

                while ($row_detalles = $result_detalles->fetch_assoc()) {
                    $nombre_producto = $row_detalles['nombre'];
                    $cantidad_producto = $row_detalles['cantidad'];
                    $precio_unitario = $row_detalles['precio_unitario'];
                    $total_producto = $cantidad_producto * $precio_unitario;

                    echo "<tr>";
                    echo "<td>$nombre_producto</td>";
                    echo "<td>$cantidad_producto</td>";
                    echo "<td>$$precio_unitario</td>";
                    echo "<td>$$total_producto</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }

        } else {
            echo "Compra no encontrada o no tienes acceso a esta compra.";
        }

        $conn->close();
    } else {
        echo "ID de compra no válido.";
    }
    ?>
</body>
</html>
