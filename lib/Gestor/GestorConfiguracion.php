<?php
Class GestorConfiguracion extends BaseGestor {

	public function __construct() {
		parent::__construct();
	}

	public function loadObject() {
		$valueObject = $this->getConfiguracionDao()->loadObject($this->getConexion(), $_SESSION["idUsuario"]);
		$fileUrl = BASE_PATH . 'Database/DBConfig.txt';
		
		if(file_exists($fileUrl)) {
			$file = file_get_contents($fileUrl);
			$fileLines = explode("\n", $file);

			foreach($fileLines as $line) {
				$line = Utils::eliminarCaracteresEspeciales($line);
				$line = explode("=", $line);

				if($line[0] == "host") {
					$valueObject->setHost($line[1]);
				} else if($line[0] == "usuario") {
					$valueObject->setUsuario($line[1]);
				} else if($line[0] == "password") {
					$valueObject->setPassword($line[1]);
				}
			}
		} else {
			throw new Exception("<b>No se puede encontrar la configuracion de la Base de Datos<b>");
		}

		return $valueObject;
	}

	public function update($valueObject) {
		$this->getConfiguracionDao()->update($this->getConexion(), $valueObject);
	}

	public function insert($valueObject) {
		$this->getConfiguracionDao()->insert($this->getConexion(), $valueObject);
	}

	public function save($valueObject) {
		if($this->isNovaConfiguracio($valueObject)) {
			$this->insert($valueObject);
		} else {
			$this->update($valueObject);
		}
	}

	public function isNovaConfiguracio($valueObject) {
		return $this->getConfiguracionDao()->isNovaConfiguracio($this->getConexion(), $valueObject);
	}
}
?>