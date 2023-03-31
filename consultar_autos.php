<style>
    .container {
        margin: auto;
        max-width: 800px;
        background-color: rgb(0, 0, 50);
        padding: 20px;
        color: white;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
<div class="container">
    <?php
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'parking');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve values submitted by the user
$marca = $_POST['marca'];
$placa = $_POST['placa'];

// Build SQL query
$sql = "SELECT * FROM autos WHERE 1=1";
if (!empty($marca)) {
    $sql .= " AND marca LIKE '%$marca%'";
}
if (!empty($placa)) {
    $sql .= " AND placa LIKE '%$placa%'";
}

// Execute SQL query
$result = mysqli_query($conn, $sql);

// Display results in an HTML table
echo "<table>";
echo "<tr><th>ID</th><th>Marca</th><th>Placa</th><th>fecha_entrada</th><th>fecha_salida</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["marca"] . "</td><td>" . $row["placa"] . "</td><td>" .$row["fecha_entrada"] . $row["fecha_salida"] . "</td><td>";
}
echo "</table>";

// Close database connection
mysqli_close($conn);
?>
