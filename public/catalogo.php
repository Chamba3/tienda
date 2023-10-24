<?php
// Realiza una consulta a la base de datos para obtener la lista de productos
require_once('../includes/db.php');

$query = "SELECT * FROM productos";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Muestra cada producto en una tarjeta
        echo "<div class='producto-card'>";
        echo "<img src='images/" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>";
        echo "<h2>" . $row['nombre'] . "</h2>";
        echo "<p>" . $row['descripcion'] . "</p>";
        echo "<p>Precio: $" . $row['precio'] . "</p>";
        echo "<p>Stock Disponible: " . $row['stock'] . "</p>";
        echo "<a href='producto.php?id=" . $row['id'] . "'>Ver Detalles</a>";
        echo "<button>Agregar al Carrito</button>";
        echo "</div>";
    }
} else {
    echo "No hay productos disponibles en el catálogo.";

}

$conn->close();
?>

