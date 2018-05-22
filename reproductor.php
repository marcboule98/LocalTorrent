<?php
require_once 'lib/lib.php';

$file = isset($_GET["url"]) ? $_GET["url"] : "";
$tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "";

if(!isset($_SESSION["idUsuario"])) {
	throw new Exception("No se encuentra la sesion del usuario");
} else {
	$stream = new VideoStream($file);
	$stream->start();
}

exit;
?>