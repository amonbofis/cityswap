<?php
 //session_start();
require_once __DIR__.'/includes/config.php';

$conn = Aplicacion::getInstance()->getConexionBd();

 // Capturo las variables username y password
$username = htmlspecialchars(trim(strip_tags($_REQUEST["username"])));
$password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));
// Proceso las variables comprobando si es un usuario valido
//query para probar si este usuario y su contrasena existe en la tabla usuario
$queryUsuario = sprintf("SELECT * FROM Usuario WHERE nombre_usuario = '%s' and contrasena = '%s'", $conn->real_escape_string($username), $conn->real_escape_string($password));
$resultadoUsuario = $conn->query($queryUsuario);

if (!$resultadoUsuario || $resultadoUsuario->num_rows === 0) {
    //si usuario no encuentro, query para buscar si existe en empresa
    $queryEmpresa = sprintf("SELECT * FROM Empresa WHERE nombre_empresa = '%s' and contrasena = '%s'", $conn->real_escape_string($username), $conn->real_escape_string($password));
    $resultadoEmpresa= $conn->query($queryEmpresa);
    echo "<h1>not a usuario</h1>";
    if (!$resultadoEmpresa || $resultadoEmpresa->num_rows === 0) {
        $_SESSION["login"] = false;
        echo "<h1>not a empresa</h1>";
        //si no encuentro, 
    } else {
        echo "<h1>empresa</h1>";
        $_SESSION["login"] = true;
        $_SESSION["nombre"] = $username;
        $_SESSION["Empresa"] = true;
    } 

} else {
    echo "<h1>Usuario</h1>";
    $_SESSION["login"] = true;
    $_SESSION["nombre"] = $username;
}

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
        // Si el acceso es correcto
        if (isset($_SESSION["login"])){
            echo "<h1>Bienvenido " .$_SESSION["nombre"] . "</h1>";
            echo "<p>Usa el menú de la izquierda para navegar.</p>";
        }
        else{
            echo "<h1>ERROR</h1>";
            echo "<p>El usuario o contraseña no son válidos.</p>";
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