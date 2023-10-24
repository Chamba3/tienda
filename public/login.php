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

    // Considerando que ya tienes un archivo db.php con tu conexión
    require_once(__DIR__ . '/../connection/db.php');

    $query = "SELECT id, contrasena FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($usuario_id, $contrasena_hash);
        $stmt->fetch();

        // Verificar la contraseña ingresada con el hash almacenado
        if (password_verify($contrasena, $contrasena_hash)) {
            $_SESSION['usuario_id'] = $usuario_id;
            header("Location: catalogo.php"); // Redirigiendo a catalogo.php
            exit;
        } else {
            $error_message = "Contraseña incorrecta. Inténtalo de nuevo.";
        }
    } else {
        $error_message = "Usuario no encontrado. Regístrate si eres nuevo.";
    }
    
   $stmt->close(); 
   $conn->close(); 
    
$contrasena = "holapa";
$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Actualiza la contraseña en la base de datos para el usuario "Maynol Sarmiento"
// $query = "UPDATE usuarios SET contrasena = ? WHERE email = 'maynol@gmail.com'";
//$stmt = $conn->prepare($query);
//$stmt->bind_param("s", $contrasena_hash);
//$stmt->execute();

//$stmt->close();
//$conn->close();

//echo "Contraseña actualizada correctamente.";

}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Inicio de Sesión</title>
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
            </form>
        </div>
    </div>
</body>
</html>





