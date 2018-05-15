<?php
require_once BASE_PATH.'/../includes/vendor/autoload.php';
use Transmission\Client;
use Transmission\Transmission;

Class ConfiguracionCtl extends BaseCtl {

	private $configuracionVO = null;
	private $gestor = null;

	public function __construct() {
		try {
			$this->getConfiguracionVO();

			if(isset($_POST["guardar"])) {
				$this->parseValueObject();
				$this->getGestor()->update($this->getConfiguracionVO());
				$this->info[] = "Guardado correctamente!";
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
		if(isset($_POST["rutaDescargas"]) && is_dir($_POST["rutaDescargas"])) {
			$this->getConfiguracionVO()->setRutaDescargas(Utils::eliminarCaracteresEspeciales($_POST["rutaDescargas"]));
		} else {
			throw new Exception("La ruta indicada no existe!");
		}

		if(isset($_POST["recibirEmailFinalizados"]) && $_POST["recibirEmailFinalizados"] == "1") {
			$this->getConfiguracionVO()->setRecibirEmailFinalizados(1);
		} else {
			$this->getConfiguracionVO()->setRecibirEmailFinalizados(0);
		}

		$this->parseTransmission();
		$this->parseDatabase();
		$this->saveTransmission();
	}

	private function parseTransmission() {
		if(isset($_POST["transmissionHost"])) {
			$this->getConfiguracionVO()->setTransmissionHost(Utils::eliminarCaracteresEspeciales($_POST["transmissionHost"]));
		}

		if(isset($_POST["transmissionPuerto"])) {
			$this->getConfiguracionVO()->setTransmissionPuerto(Utils::eliminarCaracteresEspeciales($_POST["transmissionPuerto"]));
		}

		if(isset($_POST["transmissionUsuario"])) {
			$this->getConfiguracionVO()->setTransmissionUsuario(Utils::eliminarCaracteresEspeciales($_POST["transmissionUsuario"]));
		}

		if(isset($_POST["transmissionPassword"])) {
			$this->getConfiguracionVO()->setTransmissionPassword(Utils::eliminarCaracteresEspeciales($_POST["transmissionPassword"]));
		}

		$transmission = new Transmission($this->getConfiguracionVO()->getTransmissionHost(), $this->getConfiguracionVO()->getTransmissionPuerto());

		if(!empty($_POST["transmissionUsuario"]) && $_POST["transmissionPassword"]) {
			$client = new Client();
			$client->authenticate($this->getConfiguracionVO()->getTransmissionUsuario(), $this->getConfiguracionVO()->getTransmissionPassword());
			$transmission->setClient($client);
		}

		$transmission->all();
	}

	private function saveTransmission() {
		$transmission = new Transmission();
		$session = $transmission->getSession();

		$session->setDownloadDir($this->getConfiguracionVO()->getRutaDescargas());
		$session->setIncompleteDir($this->getConfiguracionVO()->getRutaDescargas() . "/temp_dont_remove");
		$session->setIncompleteDirEnabled(true);
		$session->save();
	}

	private function parseDatabase() {
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
			throw new Exception("<b>Error al guardar la conexion:</b> " . $connTemp->connect_error);
		} else {
			file_put_contents(BASE_PATH . 'Database/DBConfig.txt', $stringDataBase);
		}
	}
}
?>