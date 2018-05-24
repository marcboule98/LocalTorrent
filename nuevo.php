<?php 
require_once 'lib/lib.php';
$ctl = new NuevoCtl();	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Nuevo Contenido - LocalTorrent</title>
	<?php require_once 'includes/header.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Utils::addArchivoNoCache("css/nuevo.css"); ?>">
</head>
<body>
	<?php require_once 'includes/sideMenu.php'; ?>

	<div class="container">
		<h1>Nuevo Contenido</h1>

		<div>
			<p id="minCaracteres">Para buscar introduce un mínimo de 3 carácteres.</p>
			<input type="text" id="search" placeholder="Buscar">
			<img src="css/loading.gif" id="loadingImg">
		</div>

		<table>
			<thead>
				<tr>
					<th>Título</th>
					<th>Idioma</th>
					<th>Calidad</th>
					<th>Tamaño</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody id="torrents"></tbody>
		</table>
		
	</div>
	<script src="<?php echo Utils::addArchivoNoCache("js/nuevo.js"); ?>"></script>
</body>
</html>