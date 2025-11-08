<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("db.php");

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Fecha Inicio');
$sheet->setCellValue('B1', 'Fecha Fin');
$sheet->setCellValue('C1', 'Motivo');
$sheet->setCellValue('D1', 'Empleado');

$sql = "SELECT a.*, e.nombre, e.apellido 
        FROM vacaciones a
        LEFT JOIN empleado e ON a.idEmpleado = e.idEmpleado
        WHERE a.fechaFin LIKE '%$busqueda%' 
        OR a.idEmpleado LIKE '%$busqueda%' 
        OR e.apellido LIKE '%$busqueda%'";

$resultado = mysqli_query($enlace, $sql);

$rowNum = 2;
while ($row = mysqli_fetch_assoc($resultado)) {
    $nombreCompleto = $row['nombre'] . ' ' . $row['apellido']; // Concatenar nombre y apellido
    $sheet->setCellValue('A' . $rowNum, $row['fechaInicio']);
    $sheet->setCellValue('B' . $rowNum, $row['fechaFin']);
    $sheet->setCellValue('C' . $rowNum, $row['motivo']);
    $sheet->setCellValue('D' . $rowNum, $nombreCompleto); // Asignar nombre completo a la celda
    $rowNum++;
}

// Autoajustar el ancho de las columnas
foreach (range('A', 'D') as $columnID) { // Solo hasta la columna D ya que solo se utilizan 4 columnas
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
$filename = 'vacaciones.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save('php://output');
?>
