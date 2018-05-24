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

	public function updateTorrentsFinalizados($torrents, $transmission) {
		$this->getGestorTorrent()->updateTorrentsFinalizados($torrents, $transmission);
	}

	public function obtenerSizeDescargasActivas() {
		return $this->getGestorTorrent()->obtenerSizeDescargasActivas();
	}

	public function isTorrentDuplicado($nombre, $size) {
		return $this->getGestorTorrent()->isTorrentDuplicado($nombre, $size);
	}
}
?>