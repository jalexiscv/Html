<?php

// WARNING: Storing database credentials in a plain text file is INSECURE.
// This is for demonstration purposes only. Use more secure methods in production.

$hostname = '10.128.0.32';
$username = 'higgs-chat';
$password = '94478998x';
$database = 'higgs-chat';

// Crear conexión
$conn = new mysqli($hostname, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener las conversaciones
$sql = "SELECT id, tipo, fecha_creacion FROM chat_conversations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los datos de cada fila
    echo "<h2>Listado de Conversaciones:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Tipo</th><th>Fecha Creación</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"]. "</td>";
        echo "<td>" . $row["tipo"]. "</td>";
        echo "<td>" . $row["fecha_creacion"]. "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron conversaciones.";
}

$conn->close();

?>