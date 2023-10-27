<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Checkout</title>
    <!-- Agrega enlaces a tus archivos CSS y otros recursos aquí -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>Checkout</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesa el formulario de pago y realiza la transacción.
        $nombre_en_tarjeta = $_POST['nombre_en_tarjeta'];
        $numero_tarjeta = $_POST['numero_tarjeta'];
        $vencimiento_tarjeta = $_POST['vencimiento_tarjeta'];

        // Aquí debes implementar la lógica para procesar el pago y registrar la compra.
        // Asegúrate de utilizar una pasarela de pago segura o un servicio de pago en línea.
        // y de que los datos de pago se almacenen de forma segura.

        // Después de procesar el pago con éxito, puedes mostrar un mensaje de confirmación.
        echo "<p>¡Compra exitosa! Se ha procesado su pago.</p>";
    } else {
        // Muestra el formulario de pago
        echo "<form method='post' action='checkout.php'>";
        echo "<label for='nombre_en_tarjeta'>Nombre en la Tarjeta:</label>";
        echo "<input type='text' id='nombre_en_tarjeta' name='nombre_en_tarjeta' required><br>";
        echo "<label for='numero_tarjeta'>Número de Tarjeta:</label>";
        echo "<input type='text' id='numero_tarjeta' name='numero_tarjeta' required><br>";
        echo "<label for='vencimiento_tarjeta'>Fecha de Vencimiento:</label>";
        echo "<input type='text' id='vencimiento_tarjeta' name='vencimiento_tarjeta' required><br>";
        echo "<button type='submit'>Realizar Pago</button>";
        echo "</form>";
    }
    ?>

</body>
</html>
