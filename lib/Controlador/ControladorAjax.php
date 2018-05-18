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
						} else if($pagina == "eliteTorrent" && $_GET["pagEliteTorrent"] == "0") {
							echo $eliteTorrent->obtenerNpaginas($input);
						} else if($pagina == "eliteTorrent" && isset($_GET["pagEliteTorrent"])) {
							echo json_encode($eliteTorrent->obtenerResultados($_GET["pagEliteTorrent"], $input));
						} else {
							throw new Exception("Error en la peticion!");
						}

						break;
					case DESCARGAR_TORRENT:
						$this->isEspacioDisponible($_GET["url"]);
						$configuracionVO = $this->getGestor()->loadConfiguracionVO();
						$torrent = $this->parseTorrent();

						$transmission = $this->getTransmissionObject($configuracionVO);

						$transmission->getClient()->call('torrent-add', array(
						    'filename' => Utils::cnvUrlSpaces20($_GET["url"]),
						    'download-dir' => $configuracionVO->getRutaDescargas() . "/" . $torrent->getCodigoTorrent()
						));
						$this->getGestor()->nuevoTorrent($torrent);

						$this->info[] = "Torrent añadido correctamente!";
						echo json_encode(array("info" => $this->info));

						break;
					case OBTENER_TORRENTS:
						echo json_encode($this->getTorrentsCliente());
						break;
					case ELIMINAR_TORRENT:
						if(isset($_GET["idTorrent"]) && $_GET["rutaBBDD"]) {
							$configuracionVO = $this->getGestor()->loadConfiguracionVO();
							$transmission = $this->getTransmissionObject($configuracionVO);

							$transmission->getClient()->call('torrent-remove', array(
							    'ids' => intval($_GET["idTorrent"]),
							    'delete-local-data' => true
							));

							$this->getGestor()->eliminarTorrent($_GET["rutaBBDD"]);

							$this->info[] = "Torrent eliminado correctamente!";
							echo json_encode(array("info" => $this->info));
						} else {
							throw new Exception("Error, no se puede eliminar el torrent!");
						}
						
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

	private function getTorrentsCliente() {
		$configuracionVO = $this->getGestor()->loadConfiguracionVO();
		$transmission = $this->getTransmissionObject($configuracionVO);
		$rutasUsuario = $this->getGestor()->getRutasTorrents();
		$torrents = array();

		foreach($transmission->all() as $torrent) {
			foreach($rutasUsuario as $ruta) {
				$rutaExplode = explode("/", $torrent->getDownloadDir());

				if($ruta == $rutaExplode[count($rutaExplode) - 1]) {
					array_push($torrents, array(
						"idTorrent" => $torrent->getId(),
						"nombre" => $torrent->getName(),
						"ratioDescarga" => $torrent->getDownloadRate() / 1000000,
						"tiempoEstimado" => $torrent->getEta(),
						"completado" => $torrent->getPercentDone(),
						"finalizado" => $torrent->isFinished(),
						"rutaBBDD" => $ruta
					));
				}
			}
		}

		return $torrents;
	}

	private function getTransmissionObject($configuracionVO) {
		$transmission = new Transmission($configuracionVO->getTransmissionHost(), $configuracionVO->getTransmissionPuerto());
		$client = new Client();
		$client->authenticate($configuracionVO->getTransmissionUsuario(), $configuracionVO->getTransmissionPassword());
		$transmission->setClient($client);

		return $transmission;
	}

	private function parseTorrent() {
		$valueObject = new TorrentVO();

		$valueObject->setIdUsuario($_SESSION["idUsuario"]);
		$valueObject->setCodigoTorrent(Utils::generarRandomString());
		$valueObject->setNombre($_GET["nombre"]);
		$valueObject->setSize($_GET["size"]);
		$valueObject->setCalidad($_GET["calidad"]);
		$valueObject->setIdioma($_GET["idioma"]);

		$type = pathinfo(Utils::cnvUrlSpaces20($_GET["img"]), PATHINFO_EXTENSION);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents(Utils::cnvUrlSpaces20($_GET["img"])));
		$valueObject->setImagen($base64);

		return $valueObject;
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