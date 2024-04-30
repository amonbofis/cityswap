<?php
/* Muestra el saludo si el usuario esta registrado,
   en caso de que no lo este, muestra que es un usuario
   desconocido. */
function mostrarSaludo(){
	if (!isset($_SESSION["login"])){
		echo "<p>Usuario desconocido. <a href=\"login.php\">Login</a></p>";
	}
	else if ($_SESSION["login"]===true){
		echo "<p>Bienvenido " . $_SESSION["nombre"] . "<a href=\"logout.php\">(salir)</a></p>";
	}

}
?>
<header>
		<h1>Mi gran página web</h1>
		<div class="saludo">
			<?php
			  mostrarSaludo();
			  ?>
		</div>
</header>