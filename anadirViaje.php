<?php
require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioNewViaje();
$htmlFormLogin = $form->gestiona();
$tituloPagina = 'Añadir Viaje';
$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

require __DIR__.'/includes/vistas/plantilla.php';
?>
