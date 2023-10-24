<?php
// logout.php
session_start();
unset($_SESSION['usuario_id']); // Remover la sesión del usuario
session_destroy(); // Destruir la sesión
header("Location: login.php"); // Redirigir al login
exit;
?>
<!-- ... otras partes del código ... -->

<div class="logout-container">
    <a href="logout.php" class="logout-button">Cerrar Sesión</a>
</div>

<!-- ... otras partes del código ... -->
