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
$sheet->setCellValue('K1', 'Oficina');
$sheet->setCellValue('L1', 'Rol');

$sql = "SELECT e.*, o.nombre AS nombreOficina, r.nombre AS nombreRol 
        FROM empleado e
        LEFT JOIN oficina o ON e.idOficina = o.idOficina
        LEFT JOIN rol r ON e.idRol = r.idRol
        WHERE e.nombre LIKE '%$busqueda%' OR e.apellido LIKE '%$busqueda%' OR e.DNI LIKE '%$busqueda%'";

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
    $sheet->setCellValue('K' . $rowNum, $row['nombreOficina']); // Mostrar el nombre de la oficina
    $sheet->setCellValue('L' . $rowNum, $row['nombreRol']); // Mostrar el nombre del rol
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
