<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Historial de Compras</title>
    <!-- Agrega enlaces a tus archivos CSS y otros recursos aquí -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>Historial de Compras</h1>

    <?php
    // Realiza una consulta a la base de datos para obtener el historial de compras del usuario
    require_once('includes/db.php');

    // Supongamos que tienes un sistema de autenticación y que el ID del usuario se obtiene desde la sesión
    $usuario_id = 1; // Reemplaza con la lógica para obtener el ID del usuario autenticado

    $query = "SELECT compras.id, compras.fecha, compras.total
              FROM compras
              WHERE compras.cliente_id = $usuario_id
              ORDER BY compras.fecha DESC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Fecha</th><th>Total</th><th>Detalles</th></tr>";

        while ($row = $result->fetch_assoc()) {
            $compra_id = $row['id'];
            $fecha_compra = $row['fecha'];
            $total_compra = $row['total'];

            echo "<tr>";
            echo "<td>$fecha_compra</td>";
            echo "<td>$$total_compra</td>";
            echo "<td><a href='detalle_compra.php?id=$compra_id'>Ver Detalles</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No tienes compras registradas en tu historial.";
    }

    $conn->close();
    ?>
</body>
</html>
