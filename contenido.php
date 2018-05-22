<?php 
require_once 'lib/lib.php'; 
$ctl = new ContenidoCtl();
$resultado = $ctl->obtenerDescargasFinalizadas();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ver Contenido - LocalTorrent</title>
	<?php require_once 'includes/header.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Utils::addArchivoNoCache("css/contenido.css"); ?>">
</head>
<body>
	<?php require_once 'includes/sideMenu.php'; ?>
	<div id="openModal" class="modalDialog">
		<div>
			<a href="#close" title="Cerrar" class="close">X</a>
			<h2 id="tituloPelicula"></h2>
			<p id="infoClick">Haz click sobre el archivo que quiera reproducir</p>
			<ul id="listaVideos"></ul>
		</div>
	</div>
	<div class="container">
		<h1>Ver contenido</h1>
	

		<input type="text" id="search" placeholder="Buscar">

		<?php if (count($resultado) > 0){ ?>
			<?php foreach ($resultado as $torrent) { ?>
				<div class="item" onclick="obtenerArchivos('<?php echo $torrent["rutaDescarga"]; ?>', this.children[1].innerText)">
					<img src="<?php echo $torrent["imagen"]; ?>">
					<p><?php echo $torrent["nombre"]; ?></p>

				</div>
			<?php } ?>
		<?php } else { ?>
			<p>Ahora mismo no tienes ningún Torrent descargado. <a href="nuevo.php">Haz clic aquí para empezar a descargar!</a></p>
		<?php } ?>
	</div>
	<script src="<?php echo Utils::addArchivoNoCache("js/contenido.js"); ?>"></script>
</body>
</html>