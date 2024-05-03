<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Pagina Principal';
$contenidoPrincipal = <<<EOS
<section class="hero">
<div class="hero-content">
    <h2>Find the Perfect Car for Your Journey</h2>
    <p>Explore our wide range of vehicles and book your rental today!</p>
    <a href="#" class="btn">Get Started</a>
</div>
</section>
EOS;

require __DIR__.'/includes/vistas/plantilla.php';
?>
