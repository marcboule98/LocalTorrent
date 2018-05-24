<?php
Class GestorContenido extends BaseGestor {

	public function __construct() {
		parent::__construct();
	}

	public function obtenerDescargasFinalizadas(){
		return $this->getGestorTorrent()->obtenerDescargasFinalizadas($_SESSION["idUsuario"]);
	}

	public function eliminarTorrent($idTorrent, $rutaDescargas) {
		if(is_dir($rutaDescargas)) {
			array_map('unlink', glob($rutaDescargas . "/*.*"));

			if(rmdir($rutaDescargas)) {
				$this->getGestorTorrent()->eliminarTorrentByIdTorrent($idTorrent);
			} else {
				throw new Exception("No se puede eliminar la carpeta del torrent.");
			}
		} else {
			throw new Exception("Error, la ruta <b>". $rutaDescargas ."</b> no existe.");
		}
	}

}
?>