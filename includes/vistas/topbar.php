<?php
// Verificar si hay una sesión activa
session_start();

// Obtener el nombre del usuario si está iniciada la sesión
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : null;
?>

<header>
    <?php if ($nombreUsuario): ?>
        <!-- Si el usuario está iniciado sesión, mostrar el topbar para usuarios logueados -->
        <div class="topbar-logged-in">
            <h1>Logo</h1>
            <nav>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Acerca de</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </nav>
            <!-- Saludo personalizado -->
            <div class="usuario-info">
                <span>Bienvenido <?php echo htmlspecialchars($nombreUsuario); ?></span>
            </div>
        </div>
    <?php else: ?>
        <!-- Si el usuario no está iniciado sesión, mostrar el topbar para usuarios no logueados -->
        <div class="topbar-logged-out">
            <h1>Welcome to CitySwap Car Rental Service</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Cars</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="registro.php">Register</a></li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</header>
