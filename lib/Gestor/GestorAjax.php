<?php
Class GestorAjax extends BaseGestor {

	public function __construct() {
		parent::__construct();
	}

	public function loadConfiguracionVO(){
		return $this->getGestorConfiguracion()->loadObject();
	}
}
?>