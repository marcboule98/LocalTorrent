
<?php
Class EliteTorrent {

	public function __construct() { }

	private function obtenerIdioma($idioma){
		if (strpos($idioma, "Español Latino") !== false) {
			return "ESPL";
		} else if(strpos($idioma, "Español Castellano") !== false){
			return "ESP";
		} else if(strpos($idioma, "Ingles") !== false){
			return "ENG";
		} else if(strpos($idioma, "VOSE") !== false) {
			return "VOSE";	
		}
		
		return "-";
	}

	public function obtenerNpaginas($nombre){
		$html = file_get_html('https://www.elitetorrent.biz/?s='.$nombre);
		$totalPaginas = 0;

		if (isset($html->find('div.paginacion')[0])) {
			$paginacion = $html->find('div.paginacion')[0]->last_child()->attr["href"];
			$totalPaginas = explode("/", $paginacion)[4];
		}

		return $totalPaginas;
	}

	public function obtenerResultados($numPag, $nombre){
		$ret = array("EliteTorrent" => array());
		$url = 'https://www.elitetorrent.biz/page/'.$numPag.'/?s=' . $nombre;
		$html = file_get_html($url);

		foreach ($html->find('div.imagen') as $key) {
			$tempArray = array(
				"nombre" => $key->children(0)->children(0)->attr["title"],
				"size" => "",
				"calidad" => "",
				"idioma" => "-"
			);
			$tempArray["img"] = $key->children(0)->children(0)->src;
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

}
?>