<?php
session_start();
$file = isset($_GET["url"]) ? "/" . $_GET["url"] : "";
$tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "";

if(!isset($_SESSION["idUsuario"])) {
	throw new Exception("No se encuentra la sesion del usuario");
} else {
	if(!file_exists($file)){
		echo $file;
		//throw new Exception("Error, no se encuentra el archivo.");
	} else if(!is_readable($file)) {
		throw new Exception("Error de lectura");
	} else {
		header('Content-Length: ' . filesize($videoFile));
		header("Content-Type: " . $tipo);
		readfile($file);
	}
}

exit;
?>