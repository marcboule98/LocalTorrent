<?php
/**
 * Clase GestorConfiguracion que controla la gestion de la configuracion
 * @author Jose Lorenzo, Marc Boule
 */
Class GestorConfiguracion extends BaseGestor {

	/**
	 * Constructor de la clase GestorContenido
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Cargamos el objecto ConfiguracionVO y lo rellenamos tanto en base de datos como en el archivo de la BBDD.
	 * @return ConfiguracionVO
	 */
	public function loadObject() {
		$valueObject = $this->getConfiguracionDao()->loadObject($this->getConexion(), $_SESSION["idUsuario"]);
		$fileUrl = BASE_PATH . 'DataBase/DBConfig.txt';
		
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
			throw new Exception("No se puede encontrar la configuracion de la Base de Datos");
		}

		return $valueObject;
	}

	/**
	 * Hacemos un update en la base de datos.
	 * @param ConfiguracionVO $valueObject
	 */
	public function update($valueObject) {
		$this->getConfiguracionDao()->update($this->getConexion(), $valueObject);
	}

	/**
	 * Hacemos un insert en la base de datos.
	 * @param ConfiguracionVO $valueObject
	 */
	public function insert($valueObject) {
		$this->getConfiguracionDao()->insert($this->getConexion(), $valueObject);
	}

	/**
	 * En base a si la configuracion es nueva, hacemos un insert o un update.
	 * @param ConfiguracionVO $valueObject
	 */
	public function save($valueObject) {
		if($this->isNovaConfiguracio($valueObject)) {
			$this->insert($valueObject);
		} else {
			$this->update($valueObject);
		}
	}

	/**
	 * Miramos en base a la configuracion si es nueva o no.
	 * @param ConfiguracionVO $valueObject
	 * @return Boolean
	 */
	public function isNovaConfiguracio($valueObject) {
		return $this->getConfiguracionDao()->isNovaConfiguracio($this->getConexion(), $valueObject);
	}
}
?>