<?php
include("validar.php");
include("db.php");

if (isset($_GET['idVacaciones'])) {
    $idVacaciones = $_GET['idVacaciones'];

    $sql = "SELECT * FROM vacaciones WHERE idVacaciones=$idVacaciones";
    $result = mysqli_query($enlace, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sql_insert = "INSERT INTO  vacaciones_eliminada (fechaInicio, fechaFin, motivo, idEmpleado)VALUES ('{$row['fechaInicio']}', '{$row['fechaFin']}', '{$row['motivo']}', '{$row['idEmpleado']}')";


        mysqli_query($enlace, $sql_insert);
        // Elimina el registro de la tabla principal
        $sql_delete = "DELETE FROM vacaciones WHERE idVacaciones = $idVacaciones";
        mysqli_query($enlace, $sql_delete);
        echo  "<script>
        alert('El registro se ha eliminado correctamente.');
        window.location.href = 'deleted.php';
      </script>";
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de vacaciones no proporcionado.";
}
?>