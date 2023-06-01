<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "nombre_usuario";
$password = "contraseña";
$dbname = "nombre_base_de_datos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Consulta para obtener los datos de la tabla
$sql = "SELECT * FROM tabla";
$result = $conn->query($sql);

// Crear objeto XML
$xml = new DOMDocument('1.0', 'UTF-8');

// Elemento raíz
$root = $xml->createElement('datos');
$xml->appendChild($root);

// Recorrer los resultados y agregar elementos al XML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $elemento = $xml->createElement('dato');

        // Agregar elementos hijos con los datos obtenidos
        $elemento->appendChild($xml->createElement('campo1', $row['campo1']));
        $elemento->appendChild($xml->createElement('campo2', $row['campo2']));
        $elemento->appendChild($xml->createElement('campo3', $row['campo3']));

        $root->appendChild($elemento);
    }
}

// Guardar el XML en un archivo
$xml->formatOutput = true;
$xml->save('datos.xml');

// Cerrar conexión a la base de datos
$conn->close();

echo "Archivo XML generado correctamente.";
?>
