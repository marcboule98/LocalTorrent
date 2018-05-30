<?php
/**
 * Clase TorrentDao que controla la base de datos de Configuracion
 * @author Jose Lorenzo, Marc Boule
 */
Class TorrentDao {

    /**
     * Constructor de la clase TorrentDao
     */
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

    /**
     * Insertamos el TorrentVO en la base de datos.
     * @param ConnMysql $conn
     * @param TorrentVO $valueObject
     * @return Boolean
     */
    public function insert($conn, $valueObject) {
        $sql = "INSERT INTO Torrent (idUsuario, codigoTorrent, nombre, size, calidad, idioma, imagen) VALUES ( ";
        $sql .= " ". $valueObject->getIdUsuario() ." , '". $valueObject->getCodigoTorrent() ."', '". $valueObject->getNombre() ."', '". $valueObject->getSize() ."', ";
        $sql .= "'". $valueObject->getCalidad() ."', '". $valueObject->getIdioma() ."', '". $valueObject->getImagen() ."') ";

        if (!$conn->query($sql)) {
            throw new Exception("<b>Error al guardar:</b> " . $conn->error);
        }
    }

    /**
     * Obtenemos las rutas de descargas de los torrents activos en base al idUsuario.
     * @param ConnMysql $conn
     * @param String $idUsuario
     * @return Array
     */
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

    /**
     * Eliminamos el torrent de la base de datos.
     * @param ConnMysql $conn
     * @param String $rutaBBDD
     */
    public function eliminarTorrent($conn, $rutaBBDD) {
        $sql = "DELETE FROM Torrent WHERE codigoTorrent = '". $rutaBBDD ."'";
        
        if (!$conn->query($sql)) {
            throw new Exception("<b>Error al eliminar:</b> " . $conn->error);
        }
    }

    /**
     * Eliminamos torrent by idTorrent
     * @param ConnMysql $conn
     * @param String $idTorrent
     */
    public function eliminarTorrentByIdTorrent($conn, $idTorrent) {
        $sql = "DELETE FROM Torrent WHERE idTorrent = '". $idTorrent ."'";
        
        if (!$conn->query($sql)) {
            throw new Exception("<b>Error al eliminar:</b> " . $conn->error);
        }
    }

    /**
     * Obtenemos las descargas finalizadas por idUsuario
     * @param ConnMysql $conn
     * @param String $idUsuario
     * @return Array
     */
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

    /**
     * Actualizamos los torrents finalizados de la base de datos.
     * @param ConnMysql $conn
     * @param String $codigoTorrent
     */
    public function updateTorrentsFinalizados($conn, $codigoTorrent) {
        $sql = "UPDATE Torrent SET finalizado = 1 WHERE codigoTorrent = '". $codigoTorrent ."' ";

        if (!$conn->query($sql)) {
            throw new Exception("<b>Error al actualizar:</b> " . $conn->error);
        }
    }

    /**
     * Obtenemos las descargas activas en base al idUsuario
     * @param ConnMysql $conn
     * @param String $idUsuario
     * @return String
     */
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

    /**
     * Obtenemos las descargas finalizadas en base al idUsuario
     * @param ConnMysql $conn
     * @param String $idUsuario
     * @return String
     */
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

    /**
     * Obtenemos el tamaño de las descargas activas.
     * @param ConnMysql $conn
     * @return String
     */
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

    /**
     * Miramos si el torrent esta duplicado.
     * @param ConnMysql $conn
     * @param String $nombre
     * @param String $size
     * @return Boolean
     */
    public function isTorrentDuplicado($conn, $nombre, $size) {
        $ret = false;

        $nombre = implode("|", explode(" ", $nombre));
        $sql = "SELECT count(idTorrent) as contador FROM Torrent WHERE nombre REGEXP '". $nombre ."' AND size = '". $size ."' AND finalizado = 0";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                $ret = (intval($row["contador"]) > 0 ? true : false);
            }
        }

        return $ret;
    }
}
?>