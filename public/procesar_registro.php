<?php
session_start();

// Considerando que ya tienes un archivo db.php con tu conexión
require_once(__DIR__ . '/../connection/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Verificar que las contraseñas coincidan
    if ($contrasena !== $confirmar_contrasena) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Hashear la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar el usuario en la base de datos
    $query = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $nombre, $email, $contrasena_hash);
    
    if ($stmt->execute()) {
        // Redirige al usuario a la página de inicio de sesión después de un registro exitoso
        header("Location: login.php");
        exit;
    } else {
        echo "Hubo un error al registrarte. Por favor, inténtalo de nuevo.";
    }
    

    $stmt->close();
    $conn->close();
}
?>
