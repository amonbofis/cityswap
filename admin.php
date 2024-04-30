<?php
 session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>

<div id="contenedor">

<?php
	require_once __DIR__.'/includes/vistas/comun/cabecera.php';
	require_once __DIR__.'/includes/vistas/comun/sidebarIzq.php';
?>

<main>
	<article>
        <?php
        // Comprobamos si el usuario es administrador
        if (isset($_SESSION["esAdmin"])){
            echo "<h1>Consola para las empresas</h1>";
            echo "<p>Aquí estarían los controles para la administración de la web.</p>";
        }
        else{
            echo "<h1>Acceso denegado</h1>";
            echo "<p>El usuario no tiene permisos para administrar la web.</p>";
        }
        ?>
	</article>
</main>

<?php
	require_once __DIR__.'/includes/vistas/comun/sidebarDer.php';
	require_once __DIR__.'/includes/vistas/comun/pie.php';
?>
</div>

</body>
</html>