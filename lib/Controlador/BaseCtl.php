<?php
/**
 * Clase BaseCtl que controla todos los controladores.
 * @author Jose Lorenzo, Marc Boule
 */
Class BaseCtl {

	/**
	 * Array de errores.
	 */
	public $errors = [];
	/**
	 * Array de info.
	 */
	public $info = [];
	/**
	 * Base Gestor
	 */
	private $baseGestor = null;

	/**
	 * Constructor de la clase BaseCtl
	 */
	public function __construct() {

	}

	/**
	 * Obtenemos el Base Gestor
	 * @return BaseGestor
	 */
	public function getBaseGestor() {
		if(is_null($this->baseGestor)) {
			$this->baseGestor = new BaseGestor();
		}

		return $this->baseGestor;
	}
}
?>