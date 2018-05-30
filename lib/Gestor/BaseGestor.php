<?php
/**
 * Clase BaseGestor que controla a todos los gestores de l'aplicacion
 * @author Jose Lorenzo, Marc Boule
 */
Class BaseGestor {

	/**
	 * Host de la base de datos
	 */
	private $host;
	/**
	 * Usuario de la base de datos
	 */
	private $usuario;
	/**
	 * Password de la base de datos
	 */
	private $password;
	/**
	 * Conexion a la base de datos
	 */
	private $conn = null;
	// Gestors
	/**
	 * Gestor Configuracion
	 */
	private $gestorConfiguracion = null;
	/**
	 * GestorTorrent
	 */
	private $gestorTorrent = null;
	/**
	 * GestorAjax
	 */
	private $gestorAjax = null;
	/**
	 * GestorContenido
	 */
	private $gestorContenido = null;
	// Daos
	/**
	 * ConfiguracionDao
	 */
	private $configuracionDao = null;
	/**
	 * TorrentDao
	 */
	private $torrentDao = null;

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

	public function getGestorTorrent() {
		if(is_null($this->gestorTorrent)) {
			$this->gestorTorrent = new GestorTorrent();
		}

		return $this->gestorTorrent;
	}

	public function getTorrentDao() {
		if(is_null($this->torrentDao)) {
			$this->torrentDao = new TorrentDao();
		}

		return $this->torrentDao;
	}

	public function getGestorAjax() {
		if(is_null($this->gestorAjax)) {
			$this->gestorAjax = new GestorAjax();
		}

		return $this->gestorAjax;
	}

	public function getGestorContenido() {
		if(is_null($this->gestorContenido)) {
			$this->gestorContenido = new GestorContenido();
		}

		return $this->gestorContenido;
	}

	public function getConexion() {
		return $this->conn;
	}

	/**
	 * Parseamos el archivo de configuracion y comprobamos que los datos sean correctos.
	 */
	private function parseConexion() {
		$fileUrl = BASE_PATH . 'DataBase/DBConfig.txt';
		
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

			if(is_null($this->conn)) {
				$this->conn = new mysqli($this->host, $this->usuario, $this->password, "LocalTorrent");
			}

			if ($this->conn->connect_error) {
    			throw new Exception("<b>Error de conexión:</b> " . $this->conn->connect_error);
			}

		} else {
			throw new Exception("No se puede encontrar la configuración de la Base de Datos");
		}
	}

	/**
	 * Obtenemos las descargas activas en base al idUsuario
	 * @return String
	 */
	public function getDescargasActivas() {
		return $this->getTorrentDao()->getDescargasActivas($this->getConexion(), $_SESSION["idUsuario"]);
	}

	/**
	 * Obtenemos las descargas finalizadas en base al idUsuario
	 * @return String
	 */
	public function getDescargasFinalizadas() {
		return $this->getTorrentDao()->getDescargasFinalizadas($this->getConexion(), $_SESSION["idUsuario"]);
	}
}
?>