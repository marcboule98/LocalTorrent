<?php
Class GestorContenido extends BaseGestor {

	public function __construct() {
		parent::__construct();
	}

	public function obtenerDescargasFinalizadas(){
		return $this->getGestorTorrent()->obtenerDescargasFinalizadas($_SESSION["idUsuario"]);
	}

}
?>