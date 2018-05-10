<?php
Class ConfiguracionVO {
	
	private $rutaDescargas;
	private $recibirEmailFinalizados;
	private $host;
	private $usuario;
	private $password;

	public function getRutaDescargas() {
		return $this->rutaDescargas;
	}

	public function setRutaDescargas($inRutaDescargas) {
		$this->rutaDescargas = $inRutaDescargas;
	}

	public function getRecibirEmailFinalizados() {
		return $this->recibirEmailFinalizados;
	}

	public function setRecibirEmailFinalizados($inRecibirEmailFinalizados) {
		$this->recibirEmailFinalizados = $inRecibirEmailFinalizados;
	}

	public function getHost() {
		return $this->host;
	}

	public function setHost($inHost) {
		$this->host = $inHost;
	}

	public function getUsuario() {
		return $this->usuario;
	}

	public function setUsuario($inUsuario) {
		$this->usuario = $inUsuario;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($inPassword) {
		$this->password = $inPassword;
	}
}
?>