<?php  
Class ContenidoCtl extends BaseCtl {

	private $gestor = null;

	public function __construct() {
		try {
			if(isset($_POST["eliminarTorrent"])) {
				$this->getGestor()->eliminarTorrent($_POST["idTorrent"], $_POST["rutaDescarga"]);
			}
		} catch (Exception $e) {
			$this->errors[] = $e->getMessage();
		}
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