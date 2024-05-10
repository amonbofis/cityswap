<?php
require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Mis viajes';
$contenidoPrincipal = '';
//función para generar la visualización de viajes
function toBox($id, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final) {
    $empr = es\ucm\fdi\aw\Empresa::getEmpresa($id);
    $emp = $empr->fetch_assoc();
    $empresa = $emp['nombre_empresa'];
    $contenido = "<div class='box-viaje'>";
    $contenido .= "<h2 class='trayecto'>$ciudad_origen => $ciudad_destino</h2>";
    $contenido .= "<div class='fecha'>From : $fecha_inicio <br> to : $fecha_final</div>";
    $contenido .= "<p class='empresa'>$empresa</p>";
    $contenido .= "<a href='index.php' class='button-viaje'>Ver viaje</a>";
    $contenido .= "</div>";
    return $contenido;
}

$contenidoPrincipal = "<div id='contenedor-viajes'>";
$id_usuario = $_SESSION['id'];
$viajes = es\ucm\fdi\aw\Alquiler::misAlquileres($id_usuario);
if ($viajes) {
    foreach($viajes as $viaje) {
        $id_alq = $viaje->getId();
        //$facturacione = es\ucm\fdi\aw\Facturacion::factPorAlq($id_alq);
        $contenidoPrincipal .= toBox($viaje->getId_empresa(), 
                                    $viaje->getCiudad_origen(), 
                                    $viaje->getCiudad_destino(),
                                    $viaje->getFecha_inicio(),
                                    $viaje->getFecha_final());
    }
} else {
    $contenidoPrincipal .= '<p>No tienes viajes reservado en este momento.</p>';
}

// Finaliza el contenedor de viajes
$contenidoPrincipal .= '</div>';
require __DIR__.'/includes/vistas/plantilla.php';
?>