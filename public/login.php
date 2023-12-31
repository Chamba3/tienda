<?php
session_start();

// Si el usuario ya inició sesión, lo redirigimos al catálogo
if (isset($_SESSION['usuario_id'])) {
    header("Location: catalogo.php");
    exit;
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    require_once(__DIR__ . '/../connection/db.php');

    // Incluye el nombre en tu consulta
    $query = "SELECT id, nombre, contrasena FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user_row = $result->fetch_assoc();
        // Ahora tienes disponible el 'nombre' en $user_row
        $usuario_id = $user_row['id'];
        $nombre_usuario = $user_row['nombre'];
        $contrasena_hash = $user_row['contrasena'];
        
        // Asigna el nombre del usuario a la sesión
        $_SESSION['usuario_nombre'] = $nombre_usuario;

        // Comparar la contraseña ingresada con la almacenada
        if (password_verify($contrasena, $contrasena_hash)) {
            $_SESSION['usuario_id'] = $usuario_id;
            
            // Redirige al catálogo
            header("Location: catalogo.php");
            exit;
        } else {
            $error_message = "Contraseña incorrecta. Inténtalo de nuevo.";
        }
    } else {
        $error_message = "Usuario no encontrado. Regístrate si eres nuevo.";
    }
    
    $stmt->close(); 
    $conn->close(); 
}
?>

<!-- El código HTML permanece igual -->

<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Inicio de Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <?php
            if (!empty($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>
            <form class='login-form' method='post' action='login.php'>
                <div class='input-group'>
                    <input type='email' id='email' name='email' placeholder='Email' required>
                </div>
                <div class='input-group'>
                    <input type='password' id='contrasena' name='contrasena' placeholder='Contraseña' required>
                </div>
                <button class='login-button' type='submit'>Iniciar Sesión</button>
                <a href="registro.php" class="register-link">Regístrate si no posees una cuenta</a>

            </form>
        </div>
    </div>
</body>
</html>





