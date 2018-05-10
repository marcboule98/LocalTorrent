<?php
Class ConfiguracionCtl extends BaseCtl {

	private $configuracionVO = null;
	private $gestor = null;

	public function __construct() {
		try {
			$this->getConfiguracionVO();

			if(isset($_POST["guardar"])) {
				$this->parseValueObject();
				$this->getGestor()->update($this->getConfiguracionVO());
			}
		} catch (Exception $e) {
			$this->errors[] = $e->getMessage();
		}
	}

	public function getConfiguracionVO() {
		if(is_null($this->configuracionVO)) {
			$this->configuracionVO = $this->getGestor()->loadObject();
		}

		return $this->configuracionVO;
	}

	private function getGestor() {
		if(is_null($this->gestor)) {
			$this->gestor = new GestorConfiguracion();
		}

		return $this->gestor;
	}

	private function parseValueObject() {
		if(isset($_POST["rutaDescargas"])) {
			$this->getConfiguracionVO()->setRutaDescargas(Utils::eliminarCaracteresEspeciales($_POST["rutaDescargas"]));
		}

		if(isset($_POST["recibirEmailFinalizados"]) && $_POST["recibirEmailFinalizados"] == "1") {
			$this->getConfiguracionVO()->setRecibirEmailFinalizados(1);
		} else {
			$this->getConfiguracionVO()->setRecibirEmailFinalizados(0);
		}

		if(isset($_POST["host"])) {
			$this->getConfiguracionVO()->setHost(Utils::eliminarCaracteresEspeciales($_POST["host"]));
		}

		if(isset($_POST["usuario"])) {
			$this->getConfiguracionVO()->setUsuario(Utils::eliminarCaracteresEspeciales($_POST["usuario"]));
		}

		if(isset($_POST["password"]) && !empty($_POST["password"])) {
			$this->getConfiguracionVO()->setPassword(Utils::eliminarCaracteresEspeciales($_POST["password"]));
		} else {
			$this->getConfiguracionVO()->setPassword("");
		}

		$stringDataBase = "host=". $this->getConfiguracionVO()->getHost() ."\nusuario=". $this->getConfiguracionVO()->getUsuario() ."\npassword=". $this->getConfiguracionVO()->getPassword();

		$connTemp = new mysqli($this->getConfiguracionVO()->getHost(), $this->getConfiguracionVO()->getUsuario(), $this->getConfiguracionVO()->getPassword(), "LocalTorrent");

		if($connTemp->connect_error) {
			throw new Exception("Error de conexion: " . $connTemp->connect_error);
		} else {
			file_put_contents(BASE_PATH . 'Database/DBConfig.txt', $stringDataBase);
		}
	}
}
?>