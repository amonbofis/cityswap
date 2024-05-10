<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioReserva.php';

// Obtener el ID del viaje de la URL y aplicar validación
$id_viaje = isset($_GET['id_viaje']) ? (int)$_GET['id_viaje'] : 0;

// Crear instancia del formulario de reserva y pasar el ID del viaje
$form = new es\ucm\fdi\aw\FormularioReserva($id_viaje);
$htmlFormReserva = $form->gestiona();

// Configurar el contenido principal
$tituloPagina = 'Reserva de Viaje';
$contenidoPrincipal = <<<EOS
    $htmlFormReserva
EOS;

// Incluir la plantilla para mostrar la página
require __DIR__.'/includes/vistas/plantilla.php';
?>
