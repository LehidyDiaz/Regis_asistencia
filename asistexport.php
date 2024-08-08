<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("db.php");

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Fecha');
$sheet->setCellValue('B1', 'Hora Entrada');
$sheet->setCellValue('C1', 'Hora Salida');
$sheet->setCellValue('D1', 'Id Empleado');

$sql = "SELECT * FROM asistencia WHERE (fecha LIKE '%$busqueda%' OR idEmpleado LIKE '%$busqueda%')";

if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $sql .= " AND (fecha >= '$fecha_inicio' AND fecha <= '$fecha_fin')";
}

$resultado = mysqli_query($enlace, $sql);

$rowNum = 2;
while ($row = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $rowNum, $row['fecha']);
    $sheet->setCellValue('B' . $rowNum, $row['horaEntrada']);
    $sheet->setCellValue('C' . $rowNum, $row['horaSalida']);
    $sheet->setCellValue('D' . $rowNum, $row['idEmpleado']);
    $rowNum++;
}

// Autoajustar el ancho de las columnas
foreach (range('A', 'D') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
$filename = 'asistencia.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save('php://output');
?>
