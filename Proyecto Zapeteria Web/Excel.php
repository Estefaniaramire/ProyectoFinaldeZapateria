<?php
  include('conexion.php');

  // Obtener los datos de la base de datos
  $query = "SELECT * FROM categoria";
  $result = mysqli_query($conexion, $query);

  // Crear el archivo Excel
  require_once 'PHPExcel/PHPExcel.php';
  $objPHPExcel = new PHPExcel();

  // Configurar el archivo Excel
  $objPHPExcel->getActiveSheet()->setCellValue('A1', 'cantidadExistente');
  $objPHPExcel->getActiveSheet()->setCellValue('B1', 'nombreCategoria');
  $objPHPExcel->getActiveSheet()->setCellValue('C1', 'seccion');
  $objPHPExcel->getActiveSheet()->setCellValue('D1', 'descripcion');

  $row = 2; // Fila inicial para los datos
  while ($data = mysqli_fetch_assoc($result)) {
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $data['cantidadExistente']);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $data['nombreCategoria']);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $data['seccion']);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $data['descripcion']);
    $row++;
  }

  // Configurar el encabezado del archivo Excel
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="datos_categoria.xlsx"');
  header('Cache-Control: max-age=0');

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('php://output');
  exit;
?>
