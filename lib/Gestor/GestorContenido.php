<?php
/**
 * Clase GestorContenido que controla la gestion del contenido
 * @author Jose Lorenzo, Marc Boule
 */
Class GestorContenido extends BaseGestor {

	/**
	 * Constructor de la clase GestorContenido
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Obtenemos las descargas finalizadas por idUsuario
	 * @return Array
	 */
	public function obtenerDescargasFinalizadas(){
		return $this->getGestorTorrent()->obtenerDescargasFinalizadas($_SESSION["idUsuario"]);
	}

	/**
	 * Eliminamos los torrents del disco local y de la base de datos.
	 * @param String $idTorrent
	 * @param String $rutaDescargas
	 */
	public function eliminarTorrent($idTorrent, $rutaDescargas) {
		if(is_dir($rutaDescargas)) {
			shell_exec("rm -rf " . $rutaDescargas);
			array_map('unlink', glob($rutaDescargas . "/*.*"));
			rmdir($rutaDescargas);
			
			$this->getGestorTorrent()->eliminarTorrentByIdTorrent($idTorrent);
		} else {
			throw new Exception("Error, la ruta <b>". $rutaDescargas ."</b> no existe.");
		}
	}

}
?>