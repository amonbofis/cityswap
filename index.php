<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Pagina Principal';
$contenidoPrincipal = <<<EOS
<section class="hero">
<div class="hero-content">
    <h2>Encuentra el auto perfecto para tu aventura!</h2>
    <p>Explora nuestra gran variedad de vehiculas y has tu alquiler hoy mismo!</p>
    <a href="#" class="btn">Comienza</a>
</div>
</section>
EOS;

require __DIR__.'/includes/vistas/plantilla.php';
?>
