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
}
?>