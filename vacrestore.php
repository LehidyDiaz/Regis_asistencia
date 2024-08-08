<?php 
include("db.php"); 

if (isset($_GET['idVacaciones'])) {
    $idVacaciones = $_GET['idVacaciones'];

    $sql = "SELECT * FROM vacaciones_eliminada WHERE idVacaciones='$idVacaciones'";
    $resultado = mysqli_query($enlace, $sql);
    
    if (mysqli_num_rows($resultado)>0){
        $row = mysqli_fetch_assoc($resultado);

        $sql_insert = "INSERT INTO vacaciones (fechaInicio, fechaFin, motivo, idEmpleado)VALUES ('{$row['fechaInicio']}', '{$row['fechaFin']}', '{$row['motivo']}', '{$row['idEmpleado']}')";
        mysqli_query($enlace, $sql_insert);

        // Elimina el registro de la tabla eliminados
        $sql_delete = "DELETE FROM vacaciones_eliminada WHERE idVacaciones ='$idVacaciones'";
        mysqli_query($enlace, $sql_delete);
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'vacconsul.php';
              </script>";;

    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de vacaciones no proporcionado.";
}
?>