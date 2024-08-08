<?php
include("db.php");

$idEmpleado = intval($_GET['idEmpleado']);
$query = "SELECT idEmpleado, nombre, apellido, telefono, fechaContratacion FROM empleado WHERE idEmpleado = $idEmpleado";
$result = mysqli_query($enlace, $query);

if ($row = mysqli_fetch_assoc($result)) {
    echo "<p>Nombre: " . $row['nombre'] . "</p>";
    echo "<p>Apellido: " . $row['apellido'] . "</p>";
    echo "<p>Teléfono: " . $row['telefono'] . "</p>";
    echo "<p>Fecha Contratación: " . $row['fechaContratacion'] . "</p>";
} else {
    echo "No se encontraron detalles para este empleado.";
}
?>
