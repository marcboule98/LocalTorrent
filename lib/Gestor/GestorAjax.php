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
}
?>