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
			<form action="" method="POST" id="formLogin">
				<h1>Bienvenido - LocalTorrent</h1>
				<div class="groupInput">
					<label>Nombre</label>
					<p id="nombreVacioLogin">El campo no puede estar vacío</p>
					<input type="text" name="nombre" id="nombreLogin" placeholder="Nombre"><br>
				</div>

				<div class="groupInput">
					<label>Contraseña</label>
					<p id="passwordVacioLogin">El campo no puede estar vacío</p>
					<input type="password" name="password" id="passwordLogin" placeholder="Contraseña"><br>
				</div>

				<input type="submit" name="login" value="Iniciar Sesión"><br>
				<p><a href="#" id="registrar">Aún no tengo usuario.</a></p>
			</form>
		</div>

		<div id="registro">
			<form action="" method="POST" id="formRegistro">
				<h1>Registro - LocalTorrent</h1>
				<div class="groupInput">
					<label>Nombre</label>
					<p id="nombreVacioRegistro">El campo no puede estar vacío</p>
					<input type="text" name="nombre" id="nombreRegistro" placeholder="Nombre"><br>
				</div>

				<div class="groupInput">
					<label>Email</label>
					<p id="emailInvalidoRegistro">El email no es válido</p>
					<input type="text" name="email" id="emailRegistro" placeholder="Email"><br>
				</div>

				<div class="groupInput">
					<label>Contraseña</label>
					<p id="passwordVacioRegistro">El campo no puede estar vacío</p>
					<input type="password" name="password" id="passwordRegistro" placeholder="Contraseña"><br>
				</div>

				<input type="submit" name="registro" value="Nuevo Usuario"><br>
				<p><a href="#" id="iniciarSession">Ya tengo una cuenta.</a></p>
			</form>
		</div>
	</div>
	<script src="<?php echo Utils::addArchivoNoCache("js/index.js"); ?>"></script>
</body>
</html>