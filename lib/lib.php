<?php
session_start();
ini_set('display_errors', 'off');
/* DEFINES */
define("BASE_PATH", __DIR__ . "/");
define("PETICION_AJAX_KEY", "peticion_ajax_key");
define("NUEVO_CONTENIDO", "nuevo_contenido");
define("DESCARGAR_TORRENT", "descargar_torrent");
define("OBTENER_TORRENTS", "obtener_torrents");
define("ELIMINAR_TORRENT", "eliminar_torrent");
define("PAUSA_PLAY_TORRENT", "pausa_play_torrent");
define("OBTENER_RUTAS_CONTENIDO", "obtener_rutas_contenido");
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