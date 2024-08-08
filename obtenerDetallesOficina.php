<?php
include("db.php");

$idOficina = intval($_GET['idOficina']);
$query = "SELECT nombre, telefono, idOficina FROM oficina WHERE idOficina = $idOficina";
$result = mysqli_query($enlace, $query);

if ($row = mysqli_fetch_assoc($result)) {
    echo "<p>Nombre: " . $row['nombre'] . "</p>";
    echo "<p>Teléfono: " . $row['telefono'] . "</p>";
} else {
    echo "No se encontraron detalles para esta posición.";
}
?>
