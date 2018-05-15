<?php
/* DEFINES */
define("BASE_PATH", __DIR__ . "/");
define("PETICION_AJAX_KEY", "peticion_ajax_key");
define("NUEVO_CONTENIDO", "nuevo_contenido");
define("DESCARGAR_TORRENT", "descargar_torrent");

/* INCLUDES */
$files = glob(BASE_PATH . 'Utils/*.php');

foreach ($files as $file) {
    require_once $file;
}

$files = glob(BASE_PATH . 'ValueObject/*.php');

foreach ($files as $file) {
    require_once $file;
}

$files = glob(BASE_PATH . 'Dao/*.php');

foreach ($files as $file) {
    require_once $file;
}

$files = glob(BASE_PATH . 'Gestor/*.php');

foreach ($files as $file) {
    require_once $file;
}

$files = glob(BASE_PATH . 'Controlador/*.php');

foreach ($files as $file) {
    require_once $file;
}
?>