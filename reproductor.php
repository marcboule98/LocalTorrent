<?php
session_start();
$file = isset($_GET["url"]) ? $_GET["url"] : "";
$tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "";

if(!isset($_SESSION["idUsuario"])) {
	throw new Exception("No se encuentra la sesion del usuario");
} else {
	if(!file_exists($file) || $file === '' || !is_readable($file)){
		header('HTTP/1.1 404 File not found', true);
		exit;
	} else {
		header('Content-Length: ' . filesize($videoFile));
		header("Content-Type: " . $tipo);
		readfile($file);
	}
}

exit;
?>