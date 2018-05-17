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
	<p>Descargas activas: <span>19</span></p>
	<p>Archivos descargados: <span>20</span></p>
	<p class="copyright">LocalTorrent · Copyright 2018</p>
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