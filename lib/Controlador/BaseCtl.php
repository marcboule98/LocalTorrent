<?php
Class BaseCtl {

	public $errors = [];
	public $info = [];
	private $baseGestor = null;

	public function __construct() {

	}

	public function getBaseGestor() {
		if(is_null($this->baseGestor)) {
			$this->baseGestor = new BaseGestor();
		}

		return $this->baseGestor;
	}
}
?>