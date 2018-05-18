<?php
Class LoginCtl extends BaseCtl {

	public function __construct() {
		try {
			if(isset($_SESSION["idUsuario"])) {
				header("Location: inicio.php");
			} else if(isset($_POST["login"])) {
				$this->login();
			} else if(isset($_POST["registro"])) {
				$this->registro();
			}
		} catch (Exception $e) {
			$this->errors[] = $e->getMessage();
		}
	}

	private function login() {
		$nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
		$password = (isset($_POST["password"]) ? $_POST["password"] : "");
		$sql = "SELECT idUsuario FROM Usuario where nombre = '". $nombre ."' AND password = md5('". $password ."')";
		$conn = $this->getConexion();
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
    		if($row = $result->fetch_assoc()) {
    			$_SESSION["idUsuario"] = $row["idUsuario"];
    			$_SESSION["nombre"] = $nombre;
    			header("Location: inicio.php");
    		}
    	} else {
    		throw new Exception("La combinacion usuario / contraseña no es correcta.");
    	}
	}

	private function registro() {
		$nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
		$email = (isset($_POST["email"]) ? $_POST["email"] : "");
		$password = (isset($_POST["password"]) ? $_POST["password"] : "");

		$sql = "SELECT idUsuario FROM Usuario where nombre = '". $nombre ."'";
		$conn = $this->getConexion();
		
		$result = $conn->query($sql);

		if ($result->num_rows == 0) {
			$sql = "INSERT INTO Usuario (nombre, email, password) VALUES ";
			$sql .= "('". $nombre ."', '". $email ."', md5('". $password ."'))";

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

	private function getConexion() {
		$fileUrl = 'lib/DataBase/DBConfig.txt';
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
}