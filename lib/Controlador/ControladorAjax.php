<?php
require_once BASE_PATH.'/../includes/vendor/autoload.php';
use Transmission\Client;
use Transmission\Transmission;

Class ControladorAjax extends BaseCtl {
	
	private $gestor = null;

	public function __construct(){
		try{
			if (isset($_GET[PETICION_AJAX_KEY]) && !empty($_GET[PETICION_AJAX_KEY])) {
				$key = Utils::eliminarCaracteresEspeciales($_GET[PETICION_AJAX_KEY]);
				switch ($key) {
					case NUEVO_CONTENIDO:
						$this->isRutaDescargasConfigurado();

						$mejorTorrent = new MejorTorrent();
						$eliteTorrent = new EliteTorrent();

						$input = str_replace(" ", "+", $_GET["input"]);
						$pagina = $_GET["pagina"];

						if ($pagina == "mejorTorrent") {
							echo json_encode($mejorTorrent->obtenerTorrents($input));
						} else if($pagina == "eliteTorrent" && !isset($_GET["pagEliteTorrent"])) {
							echo $eliteTorrent->obtenerNpaginas();
						} else if($pagina == "eliteTorrent" && isset($_GET["pagEliteTorrent"])) {
							echo json_encode($eliteTorrent->obtenerResultados($_GET["pagEliteTorrent"], $input));
						} else {
							throw new Exception("Error en la peticion!");
						}

						break;
					case DESCARGAR_TORRENT:
						$this->isEspacioDisponible($_GET["url"]);

						$transmission = new Transmission();
						$transmission->add($_GET["url"]);

						$this->info[] = "Torrent añadido correctamente";
						echo json_encode(array("info" => $this->info));
						break;
					default:
						throw new Exception("No se ha encontrado key");
						break;
				}
			}
		} catch (Exception $e) {
			$this->errors[] = $e->getMessage();
			echo json_encode(array("errors" => $this->errors));
		}
	}

	private function getGestor() {
		if(is_null($this->gestor)) {
			$this->gestor = new GestorAjax();
		}

		return $this->gestor;
	}

	private function isEspacioDisponible($url) {
		$infoT = new TorrentInfo($url);
		$configuracionVO = $this->getGestor()->loadConfiguracionVO();

		if ($infoT->size() > disk_free_space($configuracionVO->getRutaDescargas())) {
			throw new Exception("No hay espacio disponible en el disco!");
		}
	}

	private function isRutaDescargasConfigurado() {
		$configuracionVO = $this->getGestor()->loadConfiguracionVO();

		if(empty($configuracionVO->getRutaDescargas()) || is_null($configuracionVO->getRutaDescargas())) {
			throw new Exception("La ruta de descargas no puede estar vacia!");
		}
	}
}


?>