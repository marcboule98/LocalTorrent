<?php
/* DEFINES */
define("BASE_PATH", $_SERVER["DOCUMENT_ROOT"] . "/localtorrent/");

/* INCLUDES */
$dir = BASE_PATH . "lib/";

$files = glob($dir . 'Utils/*.php');

foreach ($files as $file) {
    require_once $file;
}

$files = glob($dir . 'ValueObject/*.php');

foreach ($files as $file) {
    require_once $file;
}

$files = glob($dir . 'Dao/*.php');

foreach ($files as $file) {
    require_once $file;
}

$files = glob($dir . 'Gestor/*.php');

foreach ($files as $file) {
    require_once $file;
}

$files = glob($dir . 'Controlador/*.php');

foreach ($files as $file) {
    require_once $file;
}
?>