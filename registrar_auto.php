<?php

// Conexión a la base de datos
$servername = "localhost";  // Nombre del servidor de la base de datos
$username = "root";  // Nombre de usuario de la base de datos
$password = "";  // Contraseña de la base de datos
$dbname = "parking"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificación de cupos disponibles
$cupos_disponibles = 10; // Cantidad de cupos disponibles en el estacionamiento

$sql = "SELECT COUNT(*) AS cupos_ocupados FROM cupos WHERE estado = 'ocupado'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$cupos_ocupados = $row["cupos_ocupados"];
	$cupos_disponibles = $cupos_disponibles - $cupos_ocupados;
}

if ($cupos_disponibles == 0) {
	echo "Lo sentimos, el estacionamiento está lleno.";
} else {

	// Inserción del nuevo registro en la tabla "autos"
	$placa = $_POST["placa"];
	$marca = $_POST["marca"];
	$modelo = $_POST["modelo"];
	$fecha_entrada = date("Y-m-d H:i:s");

	$sql = "INSERT INTO autos (placa, marca, modelo, fecha_entrada) VALUES ('$placa', '$marca', '$modelo', '$fecha_entrada')";
	$result = $conn->query($sql);

	// Actualización del estado del cupo correspondiente en la tabla "cupos"
	$sql = "UPDATE cupos SET estado = 'ocupado' WHERE id = (SELECT id FROM cupos WHERE estado = 'disponible' LIMIT 1)";
	$result = $conn->query($sql);

	echo "El auto con placa $placa ha sido registrado en el estacionamiento."; 
    echo '<script language="javascript">alert("El auto con placa $placa ha sido registrado en el estacionamiento.");</script>';
}

$conn->close();

?>
