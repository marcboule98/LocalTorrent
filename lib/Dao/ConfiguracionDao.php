<?php
Class ConfiguracionDao {

	public function loadObject($conn) {
		$valueObject = new ConfiguracionVO();

		$sql = "SELECT * FROM Configuracion";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
    		while($row = $result->fetch_assoc()) {
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
		$sql = "UPDATE Configuracion SET rutaDescargas = '". $valueObject->getRutaDescargas() ."', recibirEmailFinalizados = ". $valueObject->getRecibirEmailFinalizados() .", host = '". $valueObject->getTransmissionHost() ."', puerto = ". $valueObject->getTransmissionPuerto() .", usuario = '". $valueObject->getTransmissionUsuario() ."', password = '". $valueObject->getTransmissionPassword() ."' ";

		if (!$conn->query($sql)) {
			throw new Exception("<b>Error al guardar:</b> " . $conn->error);
		}
	}
}
?>