<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesa el formulario de inicio de sesión
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // Aquí debes implementar la lógica de autenticación
    require_once(__DIR__ . '/../includes/db.php');

    // Supongamos que tienes una tabla "usuarios" en tu base de datos
    $query = "SELECT id, contrasena FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($usuario_id, $contrasena_hash);
        $stmt->fetch();

        // Verifica la contraseña usando password_verify
        if (password_verify($contrasena, $contrasena_hash)) {
            // Inicio de sesión exitoso
            // Puedes redirigir al usuario a su área personal o mostrar un mensaje de bienvenida
            echo "<p class='success-message'>Bienvenido, has iniciado sesión con éxito.</p>";
        } else {
            echo "<p class='error-message'>Contraseña incorrecta. Inténtalo de nuevo.</p>";
        }
    } else {
        echo "<p class='error-message'>Usuario no encontrado. Regístrate si eres nuevo.</p>";
    }

    $stmt->close();
    $conn->close();
} ?>



