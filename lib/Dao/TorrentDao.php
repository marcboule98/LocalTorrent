<?php
Class TorrentDao {

	public function loadObjectById($conn, $id) {
		$valueObject = new TorrentVO();

		$sql = "SELECT * FROM Torrent WHERE idTorrent = ". $id ." ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
    		while($row = $result->fetch_assoc()) {
        		$valueObject->setIdTorrent($row["idTorrent"]);
        		$valueObject->setCodigoTorrent($row["codigoTorrent"]);
        		$valueObject->setNombre($row["nombre"]);
        		$valueObject->setSize($row["size"]);
        		$valueObject->setCalidad($row["calidad"]);
        		$valueObject->setIdioma($row["idioma"]);
        		$valueObject->setFinalizado($row["finalizado"]);
    		}
		}

		return $valueObject;
	}
}
?>