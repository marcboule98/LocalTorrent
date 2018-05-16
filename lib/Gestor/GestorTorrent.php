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
}
?>