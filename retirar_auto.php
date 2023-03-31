<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "parking");

// Obtener los datos del formulario de la placa
$placa = $_POST["placa"];

// Consulta SQL para buscar el registro del auto por la placa ingresada
$sql = "SELECT * FROM autos WHERE placa = '$placa'";
$resultado = mysqli_query($conexion, $sql);

// Verificar si el registro existe y no tiene fecha de salida
if (mysqli_num_rows($resultado) == 1) {
    $registro = mysqli_fetch_assoc($resultado);
    if ($registro["fecha_salida"] != null) {
        echo "El auto ya fue retirado del estacionamiento.";
    } else {
        // Actualizar la fecha de salida en la tabla "autos"
        $fecha_salida = date("Y-m-d H:i:s");
        $sql = "UPDATE autos SET fecha_salida = '$fecha_salida' WHERE id = " . $registro["id"];
        mysqli_query($conexion, $sql);

        // Actualizar el estado del cupo correspondiente en la tabla "cupos"
        $sql = "UPDATE cupos SET estado = 'disponible' WHERE id = " . $registro["id_cupo"];
        mysqli_query($conexion, $sql);

        // Calcular el tiempo de estacionamiento y el monto a cobrar
        $fecha_entrada = strtotime($registro["fecha_entrada"]);
        $fecha_salida = strtotime($fecha_salida);
        $duracion = round(($fecha_salida - $fecha_entrada) / 3600, 1); // En horas
        $monto = $duracion * 10; // Tarifa de $10 por hora

        // Mostrar el mensaje al usuario con el tiempo de estacionamiento y el monto a cobrar
        echo "Tiempo de estacionamiento: $duracion horas<br>";
        echo "Monto a cobrar: $$monto";
    }
} else {
    // El registro no existe
    echo "La placa ingresada no está registrada en el estacionamiento.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
