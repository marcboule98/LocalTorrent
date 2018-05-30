<?php
/**
 * Clase ContenidoCtl que controla la vista.
 * @author Jose Lorenzo, Marc Boule
 */
Class ContenidoCtl extends BaseCtl {

	/**
	 * Gestor Contenido
	 */
	private $gestor = null;

	/**
	 * Array descargas finalizadas.
	 */
	private $descargasFinalizadas = null;

	/**
	 * Constructor de la clase NuevoCtl
	 */
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

	/**
	 * Obtenemos el Gestor Contenido
	 * @return GestorContenido
	 */
	private function getGestor() {
		if(is_null($this->gestor)) {
			$this->gestor = new GestorContenido();
		}

		return $this->gestor;
	}

	/**
	 * Obtenemos las descargas finalizadas en base al idUsuario
	 * @return String
	 */
	private function obtenerDescargasFinalizadas(){
		return $this->getGestor()->obtenerDescargasFinalizadas();
	}

	/**
	 * Obtener descargasFinalizadas
	 * @return Array
	 */
	public function getDescargasFinalizadas() {
		return $this->descargasFinalizadas;
	}

}

?>