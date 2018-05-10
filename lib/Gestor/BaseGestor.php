<?php
Class BaseGestor {

	private $host;
	private $usuario;
	private $password;
	private $conn = null;
	// Gestors
	private $gestorConfiguracion = null;
	// Daos
	private $configuracionDao = null;

	public function __construct() {
		$this->parseConexion();
	}

	public function getGestorConfiguracion() {
		if(is_null($this->gestorConfiguracion)) {
			$this->gestorConfiguracion = new GestorConfiguracion();
		}

		return $this->gestorConfiguracion;
	}

	public function getConfiguracionDao() {
		if(is_null($this->configuracionDao)) {
			$this->configuracionDao = new ConfiguracionDao();
		}

		return $this->configuracionDao;
	}

	public function getConexion() {
		return $this->conn;
	}

	private function parseConexion() {
		$fileUrl = BASE_PATH . 'Database/DBConfig.txt';
		
		if(file_exists($fileUrl)) {
			$file = file_get_contents($fileUrl);
			$fileLines = explode("\n", $file);

			foreach($fileLines as $line) {
				$line = Utils::eliminarCaracteresEspeciales($line);
				$line = explode("=", $line);

				if($line[0] == "host") {
					$this->host = $line[1];
				} else if($line[0] == "usuario") {
					$this->usuario = $line[1];
				} else if($line[0] == "password") {
					$this->password = $line[1];
				}
			}

			$this->conn = new mysqli($this->host, $this->usuario, $this->password, "LocalTorrent");

			if ($this->conn->connect_error) {
    			throw new Exception("Error de conexion: " . $this->conn->connect_error);
			}

		} else {
			throw new Exception("No se puede encontrar la configuracion de la Base de Datos");
		}
	}
}
?>