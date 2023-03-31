<?php
// Conexión a la base de datos
$servername = "localhost";  // Nombre del servidor de la base de datos
$username = "root";  // Nombre de usuario de la base de datos
$password = "";  // Contraseña de la base de datos
$dbname = "parking";  // Nombre de la base de datos

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Procesa el login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    // Consulta SQL para verificar el usuario y la contraseña
    $sql = "SELECT id, nombre FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        // Si el usuario y la contraseña son correctos, inicia sesión
        session_start();
        $fila = $resultado->fetch_assoc();
        $_SESSION["id"] = $fila["id"];
        $_SESSION["nombre"] = $fila["nombre"];
        header("Location: bienvenido.html");
    } else {
        // Si el usuario y la contraseña no son correctos, muestra un mensaje de error
        echo "Usuario o contraseña incorrectos";
    }
}

// Cierra la conexión
$conn->close();
?>
