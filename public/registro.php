<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Registro</title>
    <!-- Agrega enlaces a tus archivos CSS y otros recursos aquí -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>Registro de Cliente</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesa el formulario de registro
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT); // Almacena la contraseña de forma segura

        // Realiza la inserción de datos en la base de datos
        require_once('includes/db.php');

        $sql = "INSERT INTO clientes (nombre, email, contrasena) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $email, $contrasena);

        if ($stmt->execute()) {
            echo "<p>Registro exitoso. Ahora puedes <a href='login.php'>iniciar sesión</a>.</p>";
        } else {
            echo "<p>Error en el registro. Inténtalo de nuevo.</p>";
        }

        $conn->close();
    } else {
        // Muestra el formulario de registro
        echo "<form method='post' action='registro.php'>";
        echo "<label for='nombre'>Nombre:</label>";
        echo "<input type='text' id='nombre' name='nombre' required><br>";
        echo "<label for='email'>Email:</label>";
        echo "<input type='email' id='email' name='email' required><br>";
        echo "<label for='contrasena'>Contraseña:</label>";
        echo "<input type='password' id='contrasena' name='contrasena' required><br>";
        echo "<button type='submit'>Registrarse</button>";
        echo "</form>";
    }
    ?>
</body>
</html>
