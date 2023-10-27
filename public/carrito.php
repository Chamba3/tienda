<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Carrito de Compras</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <h1>Carrito de Compras</h1>
    <a href="catalogo.php" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver al Catálogo
    </a>


    <?php
    session_start();

    // Verifica si el carrito de compras del usuario está vacío o no
    $carrito_vacio = empty($_SESSION['carrito']);

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
        foreach ($_SESSION['carrito'] as $producto_id => $producto) {
            echo "<tr>";
            echo "<td>" . $producto['nombre'] . "</td>";
            echo "<td>" . $producto['cantidad'] . "</td>";
            echo "<td>$" . $producto['precio_unitario'] . "</td>";
            echo "<td>$" . ($producto['cantidad'] * $producto['precio_unitario']) . "</td>";
            echo "<td>";
            echo "<form action='eliminar_del_carrito.php' method='get' class='eliminar-form'>";
            echo "<input type='number' name='cantidad' value='1' min='1' max='" . $producto['cantidad'] . "'>";
            echo "<input type='hidden' name='id' value='" . $producto_id . "'>";
            echo "<input type='submit' value='Eliminar'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";

        // Calcula el total del carrito
        $total_carrito = 0;
        foreach ($_SESSION['carrito'] as $producto) {
            $total_carrito += $producto['cantidad'] * $producto['precio_unitario'];
        }

        echo "<p>Total del Carrito: $" . $total_carrito . "</p>";
        echo "<form action='procesar_compra.php' method='post'>";
        echo '<div class="paypal-center">';
        echo '<div id="paypal-button-container"></div>';
        echo '</div>';
        echo "</form>";


        echo "</form>";
    } else {
        echo "<img src='https://www.100natural.com/delivery100/web/vistas/img/cartempty.png' alt='Carrito Vacío' class='carrito-vacio-img'>";
        
    }
    ?>

<script src="https://www.paypal.com/sdk/js?client-id=Aea6PpK3-1fLwlHkTolC6urviWivZDgkcTdAOzm4jW_yCl973lRlNScyCnWyZIRDjr3oxZwyL9TcFVwq"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $total_carrito; ?>' // Usa el total del carrito aquí
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    window.location.href = "confirmacion_compra.php";
                });
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>