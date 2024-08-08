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
$sheet->setCellValue('D1', 'Id Empleado');

$sql = "SELECT * FROM vacaciones WHERE fechaFin LIKE '%$busqueda%' OR motivo LIKE '%$busqueda%' OR idEmpleado LIKE '%$busqueda%'";
$resultado = mysqli_query($enlace, $sql);

$rowNum = 2;
while ($row = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $rowNum, $row['fechaInicio']);
    $sheet->setCellValue('B' . $rowNum, $row['fechaFin']);
    $sheet->setCellValue('C' . $rowNum, $row['motivo']);
    $sheet->setCellValue('D' . $rowNum, $row['idEmpleado']);
    $rowNum++;
}

// Autoajustar el ancho de las columnas
foreach (range('A', 'L') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
$filename = 'vacaciones.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save('php://output');
?>
