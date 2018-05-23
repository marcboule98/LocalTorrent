<?php
if(!isset($_SESSION["idUsuario"])) {
	header("Location: index.php");
}
?>
<div class="sideMenu">
	<p class="user"><?php echo $_SESSION["nombre"]; ?></p>
	<hr>
	<ul>
		<li>
			<a href="inicio.php">
				<i class="fa fa-home" aria-hidden="true"></i>Inicio
			</a>
		</li>
		<li>
			<a href="contenido.php">
				<i class="fa fa-eye" aria-hidden="true"></i>Ver Contenido
			</a>
		</li>
		<li>
			<a href="nuevo.php">
				<i class="fa fa-plus-circle" aria-hidden="true"></i>Nuevo Contenido
			</a>
		</li>
		<hr>
		<li>
			<a href="configuracion.php">
				<i class="fa fa-cog" aria-hidden="true"></i>Ajustes
			</a>
		</li>
		<li>
			<a href="salir.php">
				<i class="fa fa-sign-out" aria-hidden="true"></i>Salir
			</a>
		</li>
	</ul>
	<hr>
	<p>Descargas activas: <span><?php echo $ctl->getBaseGestor()->getDescargasActivas(); ?></span></p>
	<p>Descargas finalizadas: <span><?php echo $ctl->getBaseGestor()->getDescargasFinalizadas(); ?></span></p>
	<p class="copyright">LocalTorrent · Copyright 2018</p>
	<hr>
	<div id="logoContainer">
		<img src="./css/LogoLocalTorrent.png" alt="Logo LocalTorrent">
	</div>
</div>

<div class="sideMenuHide">
	<span id="sideMenuHideButton"> << </span>
</div>

<div class="sideMenuResponsive">
	<ul>
		<li>
			<a href="inicio.php">
				<i class="fa fa-home" aria-hidden="true"></i>
			</a>
		</li>
		<li>
			<a href="contenido.php">
				<i class="fa fa-eye" aria-hidden="true"></i>
			</a>
		</li>
		<li>
			<a href="nuevo.php">
				<i class="fa fa-plus-circle" aria-hidden="true"></i>
			</a>
		</li>
		<hr>
		<li>
			<a href="configuracion.php">
				<i class="fa fa-cog" aria-hidden="true"></i>
			</a>
		</li>
		<li>
			<a href="salir.php">
				<i class="fa fa-sign-out" aria-hidden="true"></i>
			</a>
		</li>
	</ul>
</div>
<script src="<?php echo Utils::addArchivoNoCache("js/sideMenu.js"); ?>"></script>