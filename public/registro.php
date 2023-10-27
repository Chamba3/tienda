<!DOCTYPE html>
<html>
<head>
    <title>Tienda en Línea - Registro</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Registro</h2>
            <form class='login-form' method='post' action='procesar_registro.php'>
                <div class='input-group'>
                     <input type='text' id='nombre' name='nombre' placeholder='Nombre' required>
                </div>
                <div class='input-group'>
                    <input type='email' id='email' name='email' placeholder='Email' required>
                </div>
                <div class='input-group'>
                    <input type='password' id='contrasena' name='contrasena' placeholder='Contraseña' required>
                </div>
                <div class='input-group'>
                    <input type='password' id='confirmar_contrasena' name='confirmar_contrasena' placeholder='Confirmar Contraseña' required>
                </div>
                <button class='login-button' type='submit'>Registrarse</button>
                <a href="login.php" class="register-link">¿Ya tienes una cuenta? Inicia sesión</a>
            </form>
        </div>
    </div>
</body>
</html>


