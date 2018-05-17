<?php 
	require_once 'lib/lib.php';

	if(isset($_SESSION["idUsuario"])) {
		header("Location: inicio.php");
	} else if(isset($_POST["login"])) {
		$nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
		$password = (isset($_POST["password"]) ? $_POST["password"] : "");
		$sql = "SELECT idUsuario FROM Usuario where nombre = '". $nombre ."' AND password = '". $password ."'";
		$conn = getConexion();
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
    		if($row = $result->fetch_assoc()) {
    			$_SESSION["idUsuario"] = $row["idUsuario"];
    			$_SESSION["nombre"] = $nombre;
    			header("Location: inicio.php");
    		}
    	} else {
    		throw new Exception("El usuario no se ha encontrado en el sistema.");
    	}
	} else if(isset($_POST["registro"])) {
		$nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
		$email = (isset($_POST["email"]) ? $_POST["email"] : "");
		$password = (isset($_POST["password"]) ? $_POST["password"] : "");

		$sql = "SELECT idUsuario FROM Usuario where nombre = '". $nombre ."'";
		$conn = getConexion();
		
		$result = $conn->query($sql);

		if ($result->num_rows == 0) {
			$sql = "INSERT INTO Usuario (nombre, email, password) VALUES ";
			$sql .= "('". $nombre ."', '". $email ."', '". $password ."')";

    		if($conn->query($sql)) {
    			$sql = "SELECT idUsuario FROM Usuario where idUsuario = LAST_INSERT_ID()";
    			$result = $conn->query($sql);

    			if ($result->num_rows > 0) {
		    		if($row = $result->fetch_assoc()) {
		    			$_SESSION["idUsuario"] = $row["idUsuario"];
		    			$_SESSION["nombre"] = $nombre;
		    			header("Location: inicio.php");
		    		}
		    	}
    		}
    	} else {
    		throw new Exception("El usuario ya existe en el sistema.");
    	}
	}

	function getConexion() {
		$fileUrl = 'lib/Database/DBConfig.txt';
		$conn = null;
		$host = null;
		$usuario = null;
		$password = null;
		
		if(file_exists($fileUrl)) {
			$file = file_get_contents($fileUrl);
			$fileLines = explode("\n", $file);

			foreach($fileLines as $line) {
				$line = Utils::eliminarCaracteresEspeciales($line);
				$line = explode("=", $line);

				if($line[0] == "host") {
					$host = $line[1];
				} else if($line[0] == "usuario") {
					$usuario = $line[1];
				} else if($line[0] == "password") {
					$password = $line[1];
				}
			}

			if(is_null($conn)) {
				$conn = new mysqli($host, $usuario, $password, "LocalTorrent");
			}
		}

		return $conn;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bienvenido - LocalTorrent</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
	<script src="js/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<div class="container">
		<div id="login">
			<form action="" method="POST">
				<h1>Bienvenido - LocalTorrent</h1>
				<div class="groupInput">
					<label>Nombre</label>
					<input type="text" name="nombre" placeholder="Nombre"><br>
				</div>

				<div class="groupInput">
					<label>Contraseña</label>
					<input type="text" name="password" placeholder="Contraseña"><br>
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
					<input type="text" name="password" placeholder="Contraseña"><br>
				</div>

				<input type="submit" name="registro" value="Nuevo Usuario"><br>
				<p><a href="#" id="iniciarSession">Ya tengo una cuenta.</a></p>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		$("#registro").hide();

		$("#registrar").click(function(){
			$("#registro").show();
			$("#login").hide();
		});

		$("#iniciarSession").click(function(){
			$("#registro").hide();
			$("#login").show();
		});
	</script>
</body>
</html>