<?php require_once 'lib/lib.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Ajustes - LocalTorrent</title>
	<?php require_once 'includes/header.php'; ?>
</head>
<body>
	<?php require_once 'includes/sideMenu.php'; ?>

	<div class="container">
		<h1>Ajustes</h1>
		<form action="" method="POST">
			<div class="groupInput">
				<label>Ruta Descargas</label>
				<input type="text" name="rutaDescargas" placeholder="Ruta Descargas"><br>
			</div>

			<label class="customCheckBox">
	  			<input type="checkbox" name="recibirEmailFinalizados">
	  			<span class="customCheck"><i class="fa fa-check"></i></span>
	  			<p>Recibir un email cuando las descargas finalizen.</p>
			</label>

	  		<br><h2>Configuracion Base de Datos</h2>

	  		<div class="groupInput">
	  			<label>Host</label>
	  			<input type="text" name="host" placeholder="Host">	
	  		</div>
	  		
	  		<div class="groupInput">
	  			<label>Usuario</label>
	  			<input type="text" name="usuario" placeholder="Usuario">
	  		</div>
	  		
	  		<div class="groupInput">
	  			<label>Password</label>
	  			<input type="text" name="password" placeholder="Contraseña">
	  		</div>

			<input type="submit" value="Guardar">
		</form>
	</div>
</body>
</html>