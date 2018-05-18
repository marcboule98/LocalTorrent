<?php 
require_once 'lib/lib.php';
$ctl = new LoginCtl();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bienvenido - LocalTorrent</title>
	<?php require_once 'includes/header.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Utils::addArchivoNoCache("css/index.css"); ?>">
</head>
<body>
	<div class="container">
		<?php require_once 'includes/feedback.php' ?>
		
		<div id="login">
			<form action="" method="POST">
				<h1>Bienvenido - LocalTorrent</h1>
				<div class="groupInput">
					<label>Nombre</label>
					<input type="text" name="nombre" placeholder="Nombre"><br>
				</div>

				<div class="groupInput">
					<label>Contraseña</label>
					<input type="password" name="password" placeholder="Contraseña"><br>
				</div>

				<input type="submit" name="login" value="Iniciar Sesion"><br>
				<p><a href="#" id="registrar">Aun no tengo usuario.</a></p>
			</form>
		</div>

		<div id="registro">
			<form action="" method="POST">
				<h1>Registro - LocalTorrent</h1>
				<div class="groupInput">
					<label>Nombre</label>
					<input type="text" name="nombre" placeholder="Nombre"><br>
				</div>

				<div class="groupInput">
					<label>Email</label>
					<input type="text" name="email" placeholder="Email"><br>
				</div>

				<div class="groupInput">
					<label>Contraseña</label>
					<input type="password" name="password" placeholder="Contraseña"><br>
				</div>

				<input type="submit" name="registro" value="Nuevo Usuario"><br>
				<p><a href="#" id="iniciarSession">Ya tengo una cuenta.</a></p>
			</form>
		</div>
	</div>
	<script src="<?php echo Utils::addArchivoNoCache("js/index.js"); ?>"></script>
</body>
</html>