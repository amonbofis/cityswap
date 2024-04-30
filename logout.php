<?php
 session_start();
 //Eliminamos las variables de sesion login, nombre, esAdmin
 unset($_SESSION["login"]);
 unset($_SESSION["nombre"]);
 if (isset($_SESSION["esAdmin"])){
     unset($_SESSION["esAdmin"]);
 }
 //Eliminamos la sesion
 session_destroy();

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
        <h1>Gracias por visitar nuestra web. Hasta pronto.</h1>
	</article>
</main>

<?php
	require_once __DIR__.'/includes/vistas/comun/sidebarDer.php';
	require_once __DIR__.'/includes/vistas/comun/pie.php';
?>
</div>

</body>
</html>