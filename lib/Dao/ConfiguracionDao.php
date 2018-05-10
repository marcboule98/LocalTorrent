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
    		}
		}

		return $valueObject;
	}

	public function update($conn, $valueObject) {
		$sql = "UPDATE Configuracion SET rutaDescargas = '". $valueObject->getRutaDescargas() ."', recibirEmailFinalizados = ". $valueObject->getRecibirEmailFinalizados() ." ";

		if (!$conn->query($sql)) {
			throw new Exception("Error Update: " . $conn->error);
		}
	}
}
?>