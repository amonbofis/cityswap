<?php
 require 'Aplicacion.php';

define('BD_HOST', 'localhost'); 
define('BD_NAME', 'cityswap');
define('BD_USER', 'cityswap');
define('BD_PASS', 'cityswap');

/**
 * Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación
 */
// define('RAIZ_APP', __DIR__);
// define('RUTA_APP', '');
// define('RUTA_IMGS', RUTA_APP.'img');
// define('RUTA_CSS', RUTA_APP.'CSS');
// define('RUTA_JS', RUTA_APP.'js');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

// Inicializa la aplicación
$app = Aplicacion::getInstance();
$app->init(['host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS]);