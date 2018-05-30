<?php
/**
 * Clase MejorTorrent donde obtenemos todo el contenido de la pagina web.
 * @author Jose Lorenzo
 */
Class MejorTorrent {

	/**
	 * Constructor de la clase MejorTorrent
	 */
	public function __construct() { }

	/**
	 * Obtenemos los torrents en base a un nombre
	 * @param String $idioma
	 * @return Array
	 */
	public function obtenerTorrents($nombre) {
		return $this->parseTorrents($nombre);
	}
	
	/**
	 * Parseamos los torrents de la web en base a un nombre.
	 * @param String $nombre
	 * @return Array
	 */
	private function parseTorrents($nombre) {
		$ret = array("MejorTorrent" => array());
		$url = 'http://www.mejortorrent.com/secciones.php?sec=buscador&valor=' . $nombre;
		$html = file_get_html($url);

		foreach($html->find('table', 15)->find('tbody > tr') as $tr) {
			if ( (!is_null($tr->children(1)) && ($tr->children(1)->plaintext== "Película")) ) {
				$tempArray = array(
					"nombre" => $tr->children(0)->children(0)->plaintext,
					"size" => "",
					"calidad" => $tr->children(0)->children(1)->plaintext,
					"idioma" => "-",
					"img" => "-"
				);

				$prevUrl = "http://www.mejortorrent.com" . $tr->children(0)->children(0)->attr["href"];
				$info = $this->obtenerUrlBuena($prevUrl);
				$tempArray["url"] = $info["link"];
				$tempArray["size"] = $info["size"];
				$tempArray["img"] = $info["img"];

				array_push($ret['MejorTorrent'], $tempArray);
			}
			
		}

		return $ret;
	}

	/**
	 * Obtenemos unos parametros en base a una url.
	 * @param String $prevUrl
	 * @return Array
	 */
	private function obtenerUrlBuena($prevUrl) {
		$html = file_get_html($prevUrl);
		$info = array("size" => "", "link" => "", "img" => "");
		$info['img']= $html->find('img')[1]->src;

		foreach($html->find('a') as $element) {
			if (strpos($element->href, "link_bajar") !== false) {
				$tempLink = "http://www.mejortorrent.com/" . $element->href;
				$htmlDownload = file_get_html($tempLink);

				foreach ($htmlDownload->find('a') as $element) {
					if (strpos($element->href, ".torrent") !== false) {
						$rutaExplode = explode("&name=", $element->href);
						$rutaBuena = isset($rutaExplode[1]) ? $rutaExplode[1] : $rutaExplode[0]; 

						if(strpos($rutaBuena, "uploads/torrents/peliculas") !== false) {
							$info['link'] = "http://www.mejortorrent.com" . $rutaBuena;
						} else {
							$info['link'] = "http://www.mejortorrent.com/uploads/torrents/peliculas/" . $rutaBuena;
						}
					}
				}
			}

		}

		foreach($html->find('table', 14)->find('tbody > tr > td > text') as $element) {
			if (strpos($element->plaintext, "GB") !== false) {
				$info['size'] = str_replace('GB', '', $element->plaintext);	
				$info['size'] = Utils::convertirKB('GB', $info['size']);
			} else if(strpos($element->plaintext, "MB") !== false) {
				$info['size'] = str_replace('MB', '', $element->plaintext);
				$info['size'] = Utils::convertirKB('MB', $info['size']);
			}
		}

		return $info;
	}

}
?>