<?php
Class MejorTorrent {

	public function __construct() { }

	public function obtenerTorrents($nombre) {
		return $this->parseTorrents($nombre);
	}
	
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
						$info['link'] = $element->href;
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