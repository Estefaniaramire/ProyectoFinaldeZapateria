<?php
require('fpdf/fpdf.php');
include('conexion.php');

// Función para obtener todas las categorias de la base de datos
function obtenerCategoria() {
  global $conexion;
  $query = "SELECT * FROM categoria";
  $result = mysqli_query($conexion, $query);
  return $result;
}

// Función para exportar la lista de categorías a PDF
function exportarPDF() {
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 14);
  $pdf->Cell(40, 10, 'Cantidad Existente', 1);
  $pdf->Cell(40, 10, 'Nombre Categoría', 1);
  $pdf->Cell(40, 10, 'Sección', 1);
  $pdf->Cell(40, 10, 'Descripción', 1);
  $pdf->Ln();

  $Categoria = obtenerCategoria();
  while ($row = mysqli_fetch_assoc($Categoria)) {
    $pdf->Cell(40, 10, $row['cantidadExistente'], 1);
    $pdf->Cell(40, 10, $row['nombreCategoria'], 1);
    $pdf->Cell(40, 10, $row['seccion'], 1);
    $pdf->Cell(40, 10, $row['descripcion'], 1);
    $pdf->Ln();
  }

  $pdf->Output('data.pdf', 'D');
}

// Procesar la exportación a PDF
if (isset($_POST['export_pdf'])) {
  exportarPDF();
}
