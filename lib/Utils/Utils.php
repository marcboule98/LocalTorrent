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
	 * Convertir KB a cualquier tamaño.
	 * @param String $tipo
	 * @param Integer $size Recibe el tamaño siempre en KB
	 * @return Integer
	 */
	public static function convertirKB($tipo, $size) {
		$size = str_replace(',', '.', $size);
		$size = Utils::eliminarCaracteresEspeciales($size);

		$tipos = array(
			"GB" => 1048576,
			"MB" => 1024
		);
		
		return (is_numeric($size) ? $size : 0) * $tipos[$tipo];
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

	/**
	 * Generar una string random
	 * @param String $length 
	 * @return String
	 */
	public static function generarRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }

	    return $randomString;
	}

	/**
	 * Convierte los espacios de una string URI a %20.
	 * @param String $length 
	 * @return String
	 */
	public static function cnvUrlSpaces20($string) {
		$string = preg_replace("/\s/", '%20', $string);

		return $string;
	}
}

?>