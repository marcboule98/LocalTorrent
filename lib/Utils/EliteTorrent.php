<?php
Class EliteTorrent {

	public function __construct() { }

	public function obtenerTorrents($nombre) {
		return $this->parseTorrents($nombre);
	}
	
	private function parseTorrents($nombre) {
		$ret = array("EliteTorrent" => array());
		$url = 'https://www.elitetorrent.biz/?s=' . $nombre;
		$html = file_get_html($url);

		foreach ($html->find('div.imagen') as $key) {
			$tempArray = array(
				"nombre" => $key->children(0)->attr["title"],
				"size" => "",
				"calidad" => "",
				"idioma" => "-"
			);
			$idioma = $key->children(1)->children(0)->children(0)->attr["title"];
			$tempArray["idioma"] = $this->obtenerIdioma($idioma);

			$calidad = $key->children(2)->children(0)->plaintext;
			if(!is_numeric($calidad) && strpos($calidad, "-") === false) {
				$tempArray["calidad"] = $calidad;
			} else {
				$tempArray["calidad"] = "-";
			}

			if(Utils::eliminarCaracteresEspeciales($key->children(3)->children(1)->plaintext) == "GBs") {
				$tempArray["size"] = Utils::convertirKB('GB', $key->children(3)->children(0)->plaintext);
			} else if (Utils::eliminarCaracteresEspeciales($key->children(3)->children(1)->plaintext) == "MBs") {
				$tempArray["size"] = Utils::convertirKB('MB', $key->children(3)->children(0)->plaintext);
			}

			$url = $key->children(0)->attr["href"];
			$tempArray["url"] = "http://www.elitetorrent.biz".file_get_html($url)->find("a.enlace_torrent")[0]->attr["href"];
			
			array_push($ret['EliteTorrent'], $tempArray);
		}

		return $ret;
	}

	private function obtenerIdioma($idioma){
		if (strpos($idioma, "Español Latino") !== false) {
			return "ESPL";
		} else if(strpos($idioma, "Español Castellano") !== false){
			return "ESP";
		} else if(strpos($idioma, "Ingles") !== false){
			return "ENG";
		} else if(strpos($idioma, "VOSE") !== false)
			return "VOSE";
		return "-";
	}

}
?>