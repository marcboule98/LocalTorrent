<?php
class Utils {

	/**
	 * Devuelve una url con un parametro extra para forzar la cache a descargar el archivo.
	 * @param String $url 
	 * @return String
	 */
	public static function addArchivoNoCache($url) {
		return ( file_exists($url) ? ($url . "?v=" . filemtime($url)) : $url );
	}

	/**
	 * Convertir cualquier tamaño a KB.
	 * @param String $tipo
	 * @param Integer $size 
	 * @return Integer
	 */
	public static function addArchivoNoCache($tipo, $size) {
		$tipo = str_replace(',', '.', $tipo);
		$tipos = array(
			"GB" => 1000000,
			"MB" => 1000
		);

		return $tipo * $tipos[$tipo];
	}
}

?>