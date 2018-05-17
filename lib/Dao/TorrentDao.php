<?php
Class TorrentDao {

	public function loadObjectById($conn, $id) {
		$valueObject = new TorrentVO();

		$sql = "SELECT * FROM Torrent WHERE idTorrent = ". $id ." ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
    		while($row = $result->fetch_assoc()) {
        		$valueObject->setIdTorrent($row["idTorrent"]);
                $valueObject->setIdUsuario($row["idUsuario"]);
        		$valueObject->setCodigoTorrent($row["codigoTorrent"]);
        		$valueObject->setNombre($row["nombre"]);
        		$valueObject->setSize($row["size"]);
        		$valueObject->setCalidad($row["calidad"]);
        		$valueObject->setIdioma($row["idioma"]);
                $valueObject->setImagen($row["imagen"]);
        		$valueObject->setFinalizado($row["finalizado"]);
    		}
		}

		return $valueObject;
	}

    public function insert($conn, $valueObject) {
        $sql = "INSERT INTO Torrent (idUsuario, codigoTorrent, nombre, size, calidad, idioma, imagen) VALUES ( ";
        $sql .= " ". $valueObject->getIdUsuario() ." , '". $valueObject->getCodigoTorrent() ."', '". $valueObject->getNombre() ."', '". $valueObject->getSize() ."', ";
        $sql .= "'". $valueObject->getCalidad() ."', '". $valueObject->getIdioma() ."', '". $valueObject->getImagen() ."') ";

        if (!$conn->query($sql)) {
            throw new Exception("<b>Error al guardar:</b> " . $conn->error);
        }
    }


    public function getRutasTorrents($conn, $idUsuario) {
        $ret = array();
        $sql = "SELECT codigoTorrent FROM Torrent WHERE idUsuario = ". $idUsuario ." AND finalizado = 0";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($ret, $row["codigoTorrent"]);
            }
        }

        return $ret;
    }

    public function eliminarTorrent($conn, $rutaBBDD) {
        $sql = "DELETE FROM Torrent WHERE codigoTorrent = '". $rutaBBDD ."'";
        
        if (!$conn->query($sql)) {
            throw new Exception("<b>Error al eliminar:</b> " . $conn->error);
        }
    }
}
?>