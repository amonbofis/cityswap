<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Viajes';
$contenidoPrincipal = '';
//función para generar la visualización de viajes
function toBox($id_viaje, $id_empresa, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_final, $precio) {
    $empr = es\ucm\fdi\aw\Empresa::getEmpresa($id_empresa);
    $emp = $empr->fetch_assoc();
    $empresa = $emp['nombre_empresa'];
    //print("before the link, id viaje egale a : "+ $id_empresa);
    $contenido = "<div class='box-viaje'>";
    $contenido .= "<h2 class='trayecto'>De $ciudad_origen <br> a $ciudad_destino</h2>";
    $contenido .= "<div class='fecha'>From : $fecha_inicio <br> To : $fecha_final</div>";
    $contenido .= "<p class='precio'>Precio: $precio</p>";
    $contenido .= "<p class='empresa'>Empresa: $empresa</p>";
    $contenido .= "<a href='reserva.php?id_viaje=$id_viaje' class='button-viaje'>Reservar</a>";
    $contenido .= "</div>";
    return $contenido;
}

$contenidoPrincipal = "<div id='contenedor-viajes'>";

$viajes = es\ucm\fdi\aw\Viaje::obtenerViajes();

if ($viajes) {
    foreach($viajes as $viaje) {      
        $contenidoPrincipal .= toBox($viaje->getId(),
                                    $viaje->getId_empresa(), 
                                    $viaje->getCiudad_origen(), 
                                    $viaje->getCiudad_destino(),
                                    $viaje->getFecha_inicio(),
                                    $viaje->getFecha_final(),
                                    $viaje->getPrecio());
    }
} else {
    $contenidoPrincipal .= '<p>No hay viajes disponibles en este momento.</p>';
}

// Finaliza el contenedor de viajes
$contenidoPrincipal .= '</div>';
require __DIR__.'/includes/vistas/plantilla.php';
?>
