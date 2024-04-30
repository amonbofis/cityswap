<?php
  // Inicio de sesion
  //session_start();
  require_once __DIR__.'/includes/config.php';
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
    //Sustituimos header y sidebarIzq por cod PHP
    require_once __DIR__.'/includes/vistas/comun/cabecera.php';
    require_once __DIR__.'/includes/vistas/comun/sidebarIzq.php';
?>

	<main>
	  <article>
			<h1>Bienvenido en CitySwap</h1>
			<p> Viajas entre las mas graciosas ciudades para 2$.</p>
		</article>
	</main>
	
<?php
   //Sustituimos sidebarDer y footer por cod PHP
   require_once __DIR__.'/includes/vistas/comun/sidebarDer.php';
   require_once __DIR__.'/includes/vistas/comun/pie.php';
?>

</div> <!-- Fin del contenedor -->

</body>
</html>