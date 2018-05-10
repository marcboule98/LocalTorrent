<?php 
require_once 'lib/lib.php'; 
$ctl = new ConfiguracionCtl();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Configuracion - LocalTorrent</title>
	<?php require_once 'includes/header.php'; ?>
</head>
<body>
	<?php require_once 'includes/sideMenu.php'; ?>

	<div class="container">
		<?php require_once 'includes/errors.php' ?>

		<h1>Configuracion</h1>
		<form action="" method="POST">
			<div class="groupInput">
				<label>Ruta Descargas</label>
				<input type="text" name="rutaDescargas" placeholder="Ruta Descargas" value="<?php echo $ctl->getConfiguracionVO()->getRutaDescargas(); ?>"><br>
			</div>

			<label class="customCheckBox">
	  			<input type="checkbox" name="recibirEmailFinalizados" value="1" <?php echo ($ctl->getConfiguracionVO()->getRecibirEmailFinalizados() == 1 ? 'checked="checked"' : ''); ?>>
	  			<span class="customCheck"><i class="fa fa-check"></i></span>
	  			<p>Recibir un email cuando las descargas finalizen.</p>
			</label>

	  		<br><h2>Configuracion Base de Datos</h2>

	  		<div class="groupInput">
	  			<label>Host</label>
	  			<input type="text" name="host" placeholder="Host" value="<?php echo $ctl->getConfiguracionVO()->getHost(); ?>">	
	  		</div>
	  		
	  		<div class="groupInput">
	  			<label>Usuario</label>
	  			<input type="text" name="usuario" placeholder="Usuario" value="<?php echo $ctl->getConfiguracionVO()->getUsuario(); ?>">
	  		</div>
	  		
	  		<div class="groupInput">
	  			<label>Password</label>
	  			<input type="password" name="password" placeholder="Contraseña" value="<?php echo $ctl->getConfiguracionVO()->getPassword(); ?>">
	  		</div>

			<input type="submit" name="guardar" value="Guardar">
		</form>
	</div>
</body>
</html>