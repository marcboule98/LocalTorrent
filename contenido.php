<?php require_once 'lib/lib.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Ver Contenido - LocalTorrent</title>
	<?php require_once 'includes/header.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Utils::addArchivoNoCache("css/contenido.css"); ?>">
</head>
<body>
	<?php require_once 'includes/sideMenu.php'; ?>

	<div class="container">
		<h1>Ver contenido</h1>

		<input type="text" id="search" placeholder="Buscar">

		<div class="item">
			<img src="test.jpg">
			<p>The Commuter</p>
		</div>

		<div class="item">
			<img src="test.jpg">
			<p>The Commuter</p>
		</div>

		<div class="item">
			<img src="test.jpg">
			<p>The Commuter</p>
		</div>

		<div class="item">
			<img src="test.jpg">
			<p>The Commuter</p>
		</div>

		<p>Ahora mismo no tienes ningún Torrent descargado. <a href="nuevo.php">Haz clic aquí para empezar a descargar!</a></p>

	</div>
	<script src="<?php echo Utils::addArchivoNoCache("js/contenido.js"); ?>"></script>
</body>
</html>