<?php  
Class ContenidoCtl extends BaseCtl {

	private $gestor = null;

	public function __construct() {

	}

	private function getGestor() {
		if(is_null($this->gestor)) {
			$this->gestor = new GestorContenido();
		}

		return $this->gestor;
	}

	public function obtenerDescargasFinalizadas(){
		return $this->getGestor()->obtenerDescargasFinalizadas();
	}

}

?>