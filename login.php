<?php

//Inicio del procesamiento
//session_start();

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
		<h1>Acceso al sistema</h1>

		<form action="procesarLogin.php" method="POST">
		<fieldset>
			<legend>Usuario y contraseña</legend>
			<div><label>Nombre:</label> <input type="text" name="username" /></div>
			<div><label>Contraseña:</label> <input type="password" name="password" /></div>
			<button type="submit">Enviar</button>
		</fieldset>
	</article>
</main>

<?php
	require_once __DIR__.'/includes/vistas/comun/sidebarDer.php';
	require_once __DIR__.'/includes/vistas/comun/pie.php';
?>
</div>

</body>
</html>