<?php
include("validar.php");
include("db.php");

if (isset($_GET['idAsistencia'])) {
    $idAsistencia = $_GET['idAsistencia'];

    $sql = "SELECT * FROM asistencia WHERE idAsistencia=$idAsistencia";
    $result = mysqli_query($enlace, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sql_insert = "INSERT INTO  asistencia_eliminada (fecha, horaEntrada, horaSalida, idEmpleado)VALUES ('{$row['fecha']}', '{$row['horaEntrada']}', '{$row['horaSalida']}', '{$row['idEmpleado']}')";


        mysqli_query($enlace, $sql_insert);
        // Elimina el registro de la tabla principal
        $sql_delete = "DELETE FROM asistencia WHERE idAsistencia = $idAsistencia";
        mysqli_query($enlace, $sql_delete);
        echo  "<script>
        alert('El registro se ha eliminado correctamente.');
        window.location.href = 'deleted.php';
      </script>";
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de asistencia no proporcionado.";
}
?>
