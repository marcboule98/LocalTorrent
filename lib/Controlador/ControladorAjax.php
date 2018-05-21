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

						$response = $transmission->getClient()->call('torrent-add', array(
						    'filename' => Utils::cnvUrlSpaces20($_GET["url"]),
						    'download-dir' => $configuracionVO->getRutaDescargas() . "/" . $torrent->getCodigoTorrent()
						));

						if($response->result == "success") {
							$this->getGestor()->nuevoTorrent($torrent);

							$this->info[] = "Torrent añadido correctamente!";
							echo json_encode(array("info" => $this->info));
						} else {
							throw new Exception("No se ha podido añadir el torrent.");
						}

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
					case PAUSA_PLAY_TORRENT:
						if(isset($_GET["idTorrent"])) {
							$configuracionVO = $this->getGestor()->loadConfiguracionVO();
							$transmission = $this->getTransmissionObject($configuracionVO);
							$isFound = false;

							foreach($transmission->all() as $torrent) {
								if($torrent->getId() == $_GET["idTorrent"]) {
									$isFound = true;

									if($torrent->getStatus() == 0) {
										$transmission->start($torrent);
										$this->info[] = "Torrent reanudado correctamente!";
									} else {
										$transmission->stop($torrent);
										$this->info[] = "Torrent pausado correctamente!";
									}

									break;
								}
							}

							if($isFound == true) {
								echo json_encode(array("info" => $this->info));	
							} else {
								throw new Exception("El torrent con ID (". $_GET["idTorrent"] .") no se ha encontrado");
							}
							
						} else {
							throw new Exception("No se puede reanudar/pausar la descarga.");
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
						"rutaBBDD" => $ruta,
						"isPausado" => ($torrent->getStatus() == 0 ? true : false)
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
		$valueObject->setImagen(Utils::cnvUrlSpaces20($_GET["img"]));

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