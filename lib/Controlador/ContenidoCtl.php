<?php  
Class ContenidoCtl extends BaseCtl {

	private $gestor = null;
	private $descargasFinalizadas = null;

	public function __construct() {
		try {
			if(isset($_POST["eliminarTorrent"])) {
				$this->getGestor()->eliminarTorrent($_POST["idTorrent"], $_POST["rutaDescarga"]);
			}

			$this->descargasFinalizadas = $this->obtenerDescargasFinalizadas();
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

	private function obtenerDescargasFinalizadas(){
		return $this->getGestor()->obtenerDescargasFinalizadas();
	}

	public function getDescargasFinalizadas() {
		return $this->descargasFinalizadas;
	}

}

?>