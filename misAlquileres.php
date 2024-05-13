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
    $contenido .= "<h2 class='trayecto'>De $ciudad_origen <br> a $ciudad_destino</h2>";
    $contenido .= "<div class='fecha'>From : $fecha_inicio <br> To : $fecha_final</div>";
    $contenido .= "<p class='empresa'>Empresa: $empresa</p>";
    $contenido .= "</div>";
    return $contenido;
}

$contenidoPrincipal = "<div id='contenedor-viajes'>";

$usuarioActual = es\ucm\fdi\aw\Usuario::buscaUsuario($_SESSION['nombre']);
$viajes = es\ucm\fdi\aw\Alquiler::misAlquileres($usuarioActual->getId());

if ($viajes) {
    foreach($viajes as $viaje) {
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