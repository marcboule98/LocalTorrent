<?php
/**
 * Clase GestorTorrent que controla la gestion del Torrent
 * @author Jose Lorenzo, Marc Boule
 */
Class GestorTorrent extends BaseGestor {

	/**
	 * Constructor de la clase GestorTorrent
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Cargamos el objecto TorrentVO en base a la id.
	 * @param String $idTorrent
	 * @return TorrentVO
	 */
	public function loadObjectById($id) {
		return $this->getTorrentDao()->loadObjectById($this->getConexion(), $id);
	}

	/**
	 * Insertamos el TorrentVO en la base de datos.
	 * @param TorrentVO $valueObject
	 * @return Boolean
	 */
	public function insert($valueObject) {
		return $this->getTorrentDao()->insert($this->getConexion(), $valueObject);
	}

	/**
	 * Obtenemos las rutas de descargas de los torrents activos en base al idUsuario.
	 * @param String $idUsuario
	 * @return Array
	 */
	public function getRutasTorrents($idUsuario) {
		return $this->getTorrentDao()->getRutasTorrents($this->getConexion(), $idUsuario);
	}

	/**
	 * Eliminamos el torrent de la base de datos.
	 * @param String $rutaBBDD
	 */
	public function eliminarTorrent($rutaBBDD) {
		$this->getTorrentDao()->eliminarTorrent($this->getConexion(), $rutaBBDD);
	}

	/**
	 * Obtenemos las descargas finalizadas por idUsuario
	 * @param String $idUsuario
	 * @return Array
	 */
	public function obtenerDescargasFinalizadas($idUsuario) {
		return $this->getTorrentDao()->obtenerDescargasFinalizadas($this->getConexion(), $idUsuario);
	}

	/**
	 * Eliminamos torrent by idTorrent
	 * @param String $idTorrent
	 */
	public function eliminarTorrentByIdTorrent($idTorrent) {
		$this->getTorrentDao()->eliminarTorrentByIdTorrent($this->getConexion(), $idTorrent);
	}

	/**
	 * Actualizamos los torrents finalizados de la base de datos y los eliminamos del Transmission
	 * @param Array $torrents
	 * @param TransmissionObject $transmission
	 */
	public function updateTorrentsFinalizados($torrents, $transmission) {
		foreach ($torrents as $torrent) {
			if($torrent["finalizado"] == true) {
				$transmission->getClient()->call('torrent-remove', array(
					'ids' => $torrent["idTorrent"],
					'delete-local-data' => false
				));

				$this->getTorrentDao()->updateTorrentsFinalizados($this->getConexion(), $torrent["rutaBBDD"]);
			}
		}
	}

	/**
	 * Obtenemos el tamaño de las descargas activas.
	 * @return String
	 */
	public function obtenerSizeDescargasActivas() {
		return $this->getTorrentDao()->obtenerSizeDescargasActivas($this->getConexion());
	}

	/**
	 * Miramos si el torrent esta duplicado.
	 * @param String $nombre
	 * @param String $size
	 * @return Boolean
	 */
	public function isTorrentDuplicado($nombre, $size) {
		return $this->getTorrentDao()->isTorrentDuplicado($this->getConexion(), $nombre, $size);
	}
}
?>