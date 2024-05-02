<?php
require_once __DIR__.'/includes/config.php';

//Doble seguridad: unset + destroy
unset($_SESSION['login']);
unset($_SESSION['email']);
unset($_SESSION['nombre']);
if(isset($_SESSION['apellido'])){
    unset($_SESSION['apellido']);
}

session_destroy();
$tituloPagina = 'logout';
$contenidoPrincipal = <<<EOS
<h1>Hasta pronto!</h1>
EOS;

require __DIR__.'/includes/vistas/plantilla.php';