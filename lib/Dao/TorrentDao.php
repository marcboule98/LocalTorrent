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

    public function eliminarTorrentByIdTorrent($conn, $idTorrent) {
        $sql = "DELETE FROM Torrent WHERE idTorrent = '". $idTorrent ."'";
        
        if (!$conn->query($sql)) {
            throw new Exception("<b>Error al eliminar:</b> " . $conn->error);
        }
    }

    public function obtenerDescargasFinalizadas($conn, $idUsuario) {
        $ret = array();
        $sql = "SELECT idTorrent, nombre, imagen, CONCAT((SELECT rutaDescargas FROM Configuracion WHERE idUsuario = ".$idUsuario."),'/',codigoTorrent) AS rutaDescarga FROM Torrent WHERE idUsuario = ".$idUsuario." AND finalizado = 1";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($ret, array(
                    "idTorrent" => $row["idTorrent"],
                    "nombre" => $row["nombre"],
                    "imagen" => $row["imagen"],
                    "rutaDescarga" => $row["rutaDescarga"]
                ));
            }
        }

        return $ret;
    }

    public function updateTorrentsFinalizados($conn, $codigoTorrent) {
        $sql = "UPDATE Torrent SET finalizado = 1 WHERE codigoTorrent = '". $codigoTorrent ."' ";

        if (!$conn->query($sql)) {
            throw new Exception("<b>Error al actualizar:</b> " . $conn->error);
        }
    }

    public function getDescargasActivas($conn, $idUsuario) {
        $ret = 0;
        $sql = "SELECT count(idTorrent) as numTorrents FROM Torrent WHERE finalizado = 0 AND idUsuario = ". $idUsuario ." ";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                $ret = $row["numTorrents"];
            }
        }

        return $ret;
    }

    public function getDescargasFinalizadas($conn, $idUsuario) {
        $ret = 0;
        $sql = "SELECT count(idTorrent) as numTorrents FROM Torrent WHERE finalizado = 1 AND idUsuario = ". $idUsuario ." ";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                $ret = $row["numTorrents"];
            }
        }

        return $ret;
    }

    public function obtenerSizeDescargasActivas($conn) {
        $ret = 0;
        $sql = "SELECT (sum(size) / 1000) as size FROM Torrent WHERE finalizado = 0";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                $ret = $row["size"];
            }
        }

        return $ret;

    }

    public function isTorrentDuplicado($conn, $nombre, $size) {
        $ret = false;
        $sql = "SELECT count(idTorrent) as contador FROM Torrent WHERE nombre = '". $nombre ."' AND size = '". $size ."' ";

        if($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                $ret = ($row["contador"] > 0 ? true : false);
            }
        }

        return $ret;
    }
}
?>