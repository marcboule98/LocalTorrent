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
					<th>Tamaño</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Los vengadores</td>
					<td>
						<div class="progressBarContainer activo">
							<span>90%</span>
						</div>
					</td>
					<td>36 GB</td>
					<td><i class="fa fa-trash"></i></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>