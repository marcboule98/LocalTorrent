<?php
Class ConfiguracionVO {
	
	private $idUsuario;
	private $rutaDescargas;
	private $recibirEmailFinalizados;
	private $host;
	private $usuario;
	private $password;
	private $transmissionHost;
	private $transmissionPuerto;
	private $transmissionUsuario;
	private $transmissionPassword;

	public function getIdUsuario() {
		return $this->idUsuario;
	}

	public function setIdUsuario($inIdUsuario) {
		$this->idUsuario = $inIdUsuario;
	}

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

	public function getTransmissionHost() {
		return $this->transmissionHost;
	}

	public function setTransmissionHost($inTransmissionHost) {
		$this->transmissionHost = $inTransmissionHost;
	}

	public function getTransmissionPuerto() {
		if(empty($this->transmissionPuerto)) {
			$this->transmissionPuerto = "null";
		}

		return $this->transmissionPuerto;
	}

	public function setTransmissionPuerto($inTransmissionPuerto) {
		$this->transmissionPuerto = $inTransmissionPuerto;
	}

	public function getTransmissionUsuario() {
		return $this->transmissionUsuario;
	}

	public function setTransmissionUsuario($inTransmissionUsuario) {
		$this->transmissionUsuario = $inTransmissionUsuario;
	}

	public function getTransmissionPassword() {
		return $this->transmissionPassword;
	}

	public function setTransmissionPassword($inTransmissionPassword) {
		$this->transmissionPassword = $inTransmissionPassword;
	}
}
?>