<?php 
Class TorrentVO {
	private $idTorrent;
	private $codigoTorrent;
	private $nombre;
	private $size;
	private $calidad;
	private $idioma;
	private $finalizado;

	public function getIdTorrent(){
		return $this->idTorrent;
	}

	public function setIdTorrent($idTorrent){
		$this->idTorrent = $idTorrent;
	}

	public function getCodigoTorrent(){
		return $this->codigoTorrent;
	}

	public function setCodigoTorrent($codigoTorrent){
		$this->codigoTorrent = $codigoTorrent;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getSize(){
		return $this->size;
	}

	public function setSize($size){
		$this->size = $size;
	}

	public function getCalidad(){
		return $this->calidad;
	}

	public function setCalidad($calidad){
		$this->calidad = $calidad;
	}

	public function getIdioma(){
		return $this->idioma;
	}

	public function setIdioma($idioma){
		$this->idioma = $idioma;
	}

	public function getFinalizado(){
		return $this->finalizado;
	}

	public function setFinalizado($finalizado){
		$this->finalizado = $finalizado;
	}	
}
?>