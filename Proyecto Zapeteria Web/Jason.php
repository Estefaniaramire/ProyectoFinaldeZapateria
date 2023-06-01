<?php
include('conexion.php');

// Función para obtener todas las categorias de la base de datos
function obtenerCategoria()
{
  global $conexion;
  $query = "SELECT * FROM categoria";
  $result = mysqli_query($conexion, $query);
  return $result;
}

// Obtener todas las categorias
$categorias = obtenerCategoria();

// Crear un array para almacenar las categorias
$datos = array();

// Recorrer las categorias y guardar los datos en el array
while ($row = mysqli_fetch_assoc($categorias)) {
  $datos[] = $row;
}

// Convertir el array a formato JSON
$jason = json_encode($datos);

// Establecer las cabeceras del archivo JSON
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="categorias.json"');

// Descargar el archivo JSON
echo $jason;
?>
