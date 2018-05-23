<?php
Class GestorTorrent extends BaseGestor {

	public function __construct() {
		parent::__construct();
	}

	public function loadObjectById($id) {
		return $this->getTorrentDao()->loadObjectById($this->getConexion(), $id);
	}

	public function insert($valueObject) {
		return $this->getTorrentDao()->insert($this->getConexion(), $valueObject);
	}

	public function getRutasTorrents($idUsuario) {
		return $this->getTorrentDao()->getRutasTorrents($this->getConexion(), $idUsuario);
	}

	public function eliminarTorrent($rutaBBDD) {
		$this->getTorrentDao()->eliminarTorrent($this->getConexion(), $rutaBBDD);
	}

	public function obtenerDescargasFinalizadas($idUsuario) {
		return $this->getTorrentDao()->obtenerDescargasFinalizadas($this->getConexion(), $idUsuario);
	}

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
}
?>