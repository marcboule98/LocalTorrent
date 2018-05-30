<?php
/**
 * Clase GestorAjax que controla la gestion de las peticiones Ajax
 * @author Jose Lorenzo, Marc Boule
 */
Class GestorAjax extends BaseGestor {

	/**
	 * Constructor de la clase GestorContenido
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Cargamos el object ConfiguracionVO
	 * @return ConfiguracionVO
	 */
	public function loadConfiguracionVO(){
		return $this->getGestorConfiguracion()->loadObject();
	}

	/**
	 * Añadimos un nuevo Torrent en la base de datos
	 * @param TorrentVO $valueObject
	 * @return Boolean
	 */
	public function nuevoTorrent($valueObject) {
		return $this->getGestorTorrent()->insert($valueObject);
	}

	/**
	 * Obtenemos las rutas de descargas de los torrents activos en base al idUsuario.
	 * @return Array
	 */
	public function getRutasTorrents() {
		return $this->getGestorTorrent()->getRutasTorrents($_SESSION["idUsuario"]);
	}

	/**
	 * Eliminamos el torrent de la base de datos.
	 * @param String $rutaBBDD
	 */
	public function eliminartorrent($rutaBBDD) {
		$this->getGestorTorrent()->eliminarTorrent($rutaBBDD);
	}

	/**
	 * Actualizamos los torrents finalizados de la base de datos y los eliminamos del Transmission
	 * @param Array $torrents
	 * @param TransmissionObject $transmission
	 */
	public function updateTorrentsFinalizados($torrents, $transmission) {
		$this->getGestorTorrent()->updateTorrentsFinalizados($torrents, $transmission);
	}

	/**
	 * Obtenemos el tamaño de las descargas activas.
	 * @return String
	 */
	public function obtenerSizeDescargasActivas() {
		return $this->getGestorTorrent()->obtenerSizeDescargasActivas();
	}

	/**
	 * Miramos si el torrent esta duplicado.
	 * @param String $nombre
	 * @param String $size
	 * @return Boolean
	 */
	public function isTorrentDuplicado($nombre, $size) {
		return $this->getGestorTorrent()->isTorrentDuplicado($nombre, $size);
	}
}
?>