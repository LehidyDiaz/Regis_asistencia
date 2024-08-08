<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("db.php");

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Imagen');
$sheet->setCellValue('B1', 'Nombres');
$sheet->setCellValue('C1', 'Apellidos');
$sheet->setCellValue('D1', 'DNI');
$sheet->setCellValue('E1', 'Fecha Nacimiento');
$sheet->setCellValue('F1', 'Dirección');
$sheet->setCellValue('G1', 'Telefono');
$sheet->setCellValue('H1', 'Email');
$sheet->setCellValue('I1', 'Fecha de Contratación');
$sheet->setCellValue('J1', 'Salario');
$sheet->setCellValue('K1', 'Id Oficina');
$sheet->setCellValue('L1', 'Id Posición');

$sql = "SELECT * FROM empleado WHERE nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' OR DNI LIKE '%$busqueda%'";
$resultado = mysqli_query($enlace, $sql);

$rowNum = 2;
while ($row = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $rowNum, $row['imagen']);
    $sheet->setCellValue('B' . $rowNum, $row['nombre']);
    $sheet->setCellValue('C' . $rowNum, $row['apellido']);
    $sheet->setCellValue('D' . $rowNum, $row['DNI']);
    $sheet->setCellValue('E' . $rowNum, $row['fechaNacimiento']);
    $sheet->setCellValue('F' . $rowNum, $row['direccion']);
    $sheet->setCellValue('G' . $rowNum, $row['telefono']);
    $sheet->setCellValue('H' . $rowNum, $row['email']);
    $sheet->setCellValue('I' . $rowNum, $row['fechaContratacion']);
    $sheet->setCellValue('J' . $rowNum, $row['salario']);
    $sheet->setCellValue('K' . $rowNum, $row['idOficina']);
    $sheet->setCellValue('L' . $rowNum, $row['idRol']);
    $rowNum++;
}

// Autoajustar el ancho de las columnas
foreach (range('A', 'L') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
$filename = 'empleados.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save('php://output');
?>
