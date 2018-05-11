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
	public static function convertirKB($tipo, $size) {
		$size = str_replace(',', '.', $size);
		$size = Utils::eliminarCaracteresEspeciales($size);

		$tipos = array(
			"GB" => 1000000,
			"MB" => 1000
		);
		
		return $size * $tipos[$tipo];
	}

	/**
	 * Eliminar caracteres especiales.
	 * @param String $string 
	 * @return String
	 */
	public static function eliminarCaracteresEspeciales($string) {
		$string = preg_replace("/\s|&nbsp;/", '', $string);
		$string = preg_replace("/\s/", '', $string);

		if(empty($string)) {
			$string = NULL;
		}

		return $string;
	}
}

?>