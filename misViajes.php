<?php
require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Mis viajes';
$contenidoPrincipal = '';
//función para generar la visualización de alquilers
function toBox($id, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final) {
    $empr = es\ucm\fdi\aw\Empresa::getEmpresa($id);
    $emp = $empr->fetch_assoc();
    $empresa = $emp['nombre_empresa'];
    $contenido = "<div class='box-viaje'>";
    $contenido .= "<h2 class='trayecto'>$ciudad_origen => $ciudad_destino</h2>";
    $contenido .= "<div class='fecha'>From : $fecha_inicio <br> to : $fecha_final</div>";
    $contenido .= "<p class='empresa'>$empresa</p>";
    $contenido .= "<a href='index.php' class='button-viaje'>Ver alquiler</a>";
    $contenido .= "</div>";
    return $contenido;
}

$contenidoPrincipal = "<div id='contenedor-viajes'>";
$id_usuario = $_SESSION['id'];
$alquilers = es\ucm\fdi\aw\Alquiler::alquilersRes($id_usuario);
if ($alquilers) {
    foreach($alquilers as $alquiler) {
        $id_alq = $alquiler->getId();
        $facturacione = es\ucm\fdi\aw\Facturation::factPorAlq($id_alq);
        $contenidoPrincipal .= toBox($alquiler->getId_empresa(), 
                                    $alquiler->getCiudad_origen(), 
                                    $alquiler->getCiudad_destino(),
                                    $alquiler->getFecha_inicio(),
                                    $alquiler->getFecha_final());
    }
} else {
    $contenidoPrincipal .= '<p>No tienes alquileres reservado en este momento.</p>';
}

// Finaliza el contenedor de alquilers
$contenidoPrincipal .= '</div>';
require __DIR__.'/includes/vistas/plantilla.php';
?>