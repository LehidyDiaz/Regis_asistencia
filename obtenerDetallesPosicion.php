<?php
include("db.php");

$idRol = intval($_GET['idRol']);
$query = "SELECT nombre, salarioBase, idRol FROM rol WHERE idRol = $idRol";
$result = mysqli_query($enlace, $query);

if ($row = mysqli_fetch_assoc($result)) {
    echo "<p>Nombre: " . $row['nombre'] . "</p>";
    echo "<p>Salario Base: " . $row['salarioBase'] . "</p>";
} else {
    echo "No se encontraron detalles para esta posición.";
}
?>
