<?php
Class ConfiguracionDao {

	public function loadObject($conn, $idUsuario) {
		$valueObject = new ConfiguracionVO();

		$sql = "SELECT * FROM Configuracion WHERE idUsuario = ". $idUsuario ." ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
    		while($row = $result->fetch_assoc()) {
    			$valueObject->setIdUsuario($row["idUsuario"]);
        		$valueObject->setRutaDescargas($row["rutaDescargas"]);
        		$valueObject->setRecibirEmailFinalizados($row["recibirEmailFinalizados"]);
        		$valueObject->setTransmissionHost($row["host"]);
        		$valueObject->setTransmissionPuerto($row["puerto"]);
        		$valueObject->setTransmissionUsuario($row["usuario"]);
        		$valueObject->setTransmissionPassword($row["password"]);
    		}
		}

		return $valueObject;
	}

	public function update($conn, $valueObject) {
		$sql = "UPDATE Configuracion SET rutaDescargas = '". $valueObject->getRutaDescargas() ."', recibirEmailFinalizados = ". $valueObject->getRecibirEmailFinalizados() .", host = '". $valueObject->getTransmissionHost() ."', puerto = ". $valueObject->getTransmissionPuerto() .", usuario = '". $valueObject->getTransmissionUsuario() ."', password = '". $valueObject->getTransmissionPassword() ."' WHERE idUsuario = ". $valueObject->getIdUsuario() ." ";

		if (!$conn->query($sql)) {
			throw new Exception("<b>Error al guardar:</b> " . $conn->error);
		}
	}

	public function insert($conn, $valueObject) {
		$sql = "INSERT INTO Configuracion (idUsuario, rutaDescargas, recibirEmailFinalizados, host, puerto, usuario, password) VALUES (". $valueObject->getIdUsuario() .", '". $valueObject->getRutaDescargas() ."', '". $valueObject->getRecibirEmailFinalizados() ."', '". $valueObject->getTransmissionHost() ."', ". $valueObject->getTransmissionPuerto() .", '". $valueObject->getTransmissionUsuario() ."', '". $valueObject->getTransmissionPassword() ."')";

		if (!$conn->query($sql)) {
			throw new Exception("<b>Error al guardar:</b> " . $conn->error);
		}
	}

	public function isNovaConfiguracio($conn, $valueObject) {
		$sql = "SELECT count(idUsuario) as isNovaConfiguracio FROM Configuracion WHERE idUsuario = ". $valueObject->getIdUsuario() ." ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
    		if($row = $result->fetch_assoc()) {
    			if($row["isNovaConfiguracio"] == 0) {
    				return true;
    			}
    		}
    	}

		return false;
	}
}
?>