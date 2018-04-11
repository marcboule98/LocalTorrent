<?php
class Utils {

	/**
	 * Devuelve una url con un parametro extra para forzar la cache a descargar el archivo.
	 * @param String $url 
	 * @return String
	 */
	public static function addArchivoNoCache($url) {
		return ( file_exists(BASE_PATH . $url) ? ($url . "?v=" . filemtime(BASE_PATH . $url)) : $url );
	}
}

?>