<?php
require_once 'includes/vendor/autoload.php';
use Transmission\Transmission;

$transmission = new Transmission();
$torrent = $transmission->get(1);

$transmission->remove($torrent, true);
?>