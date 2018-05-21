<?php require_once 'lib/lib.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Inicio - LocalTorrent</title>
	<?php require_once 'includes/header.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Utils::addArchivoNoCache("css/inicio.css"); ?>">
</head>
<body>
	<?php require_once 'includes/sideMenu.php'; ?>

	<div class="container">
		<h1>Inicio</h1>

		<table>
			<thead>
				<tr>
					<th>Titulo</th>
					<th>Progreso</th>
					<th>Descarga</th>
					<th>Restante</th>
					<th>#</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody id="torrents"></tbody>
		</table>
	</div>
	<script src="<?php echo Utils::addArchivoNoCache("js/inicio.js"); ?>"></script>
</body>
</html>