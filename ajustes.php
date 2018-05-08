<?php require_once 'lib/lib.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Ver Contenido - LocalTorrent</title>
	<?php require_once 'includes/header.php'; ?>
</head>
<body>
	<?php require_once 'includes/sideMenu.php'; ?>

	<div class="container">
		<h1>Ajustes</h1>
		<form action="" method="POST">
			<input type="text" id="search" name="rutaDescargas" placeholder="Ruta Descargas"><br>

			<label class="customCheckBox">
	  			<input type="checkbox" name="recibirEmailFinalizados">
	  			<span class="customCheck"><i class="fa fa-check"></i></span>
	  			<p>Recibir un email cuando las descargas finalizen.</p>
			</label>

			<input type="submit" value="Guardar">
		</form>
	</div>
</body>
</html>