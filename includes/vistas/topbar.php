<?php
// Verificar si hay una sesión activa
//session_start();

// Obtener el nombre del usuario si está iniciada la sesión
?>

<header>
    <?php 
    $nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : null;

    if ($nombreUsuario && isset($_SESSION['empresa'])): ?>
        <!-- Si el usuario está iniciado sesión, mostrar el topbar para usuarios logueados -->
        <div class="topbar-logged-in">
            <h1>City Swap</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="anadirViaje.php">Anadir Viaje</a></li>
                    <li><a href="logout.php">Cerrar sesion</a></li>
                </ul>
            </nav>
            <!-- Saludo personalizado -->
            <div class="usuario-info">
                <span>Bienvenido <?php echo htmlspecialchars($nombreUsuario); ?></span>
            </div>
        </div>
    <?php elseif ($nombreUsuario && ! isset($_SESSION['empresa'])): ?>
        <!-- Si el usuario no está iniciado sesión, mostrar el topbar para usuarios no logueados -->
        <div class="topbar-logged-in">
            <h1>City Swap</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="viajes.php">Reservar Viaje</a></li>
                    <li><a href="misAlquileres.php">Mis Alquileres</a></li>
                    <li><a href="logout.php">Cerrar sesion</a></li>
                </ul>
            </nav>
        </div>
    <?php else: ?>
        <!-- Si el usuario no está iniciado sesión, mostrar el topbar para usuarios no logueados -->
        <div class="topbar-logged-out">
            <h1>Bienvenido a CitySwap!</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="login.php">Iniciar sesion</a></li>
                    <li><a href="registro.php">Registrarse</a></li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</header>
