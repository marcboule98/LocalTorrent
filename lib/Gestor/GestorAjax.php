<?php
Class GestorAjax extends BaseGestor {

	public function __construct() {
		parent::__construct();
	}

	public function loadConfiguracionVO(){
		return $this->getGestorConfiguracion()->loadObject();
	}

	public function nuevoTorrent($valueObject) {
		return $this->getGestorTorrent()->insert($valueObject);
	}

	public function getRutasTorrents() {
		return $this->getGestorTorrent()->getRutasTorrents($_SESSION["idUsuario"]);
	}

	public function eliminartorrent($rutaBBDD) {
		$this->getGestorTorrent()->eliminarTorrent($rutaBBDD);
	}

	public function updateTorrentsFinalizados($torrents) {
		$this->getGestorTorrent()->updateTorrentsFinalizados($torrents);
	}
}
?>