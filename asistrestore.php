<?php 
include("db.php"); 

if (isset($_GET['idAsistencia'])) {
    $idAsistencia = $_GET['idAsistencia'];

    $sql = "SELECT * FROM asistencia_eliminada WHERE idAsistencia='$idAsistencia'";
    $resultado = mysqli_query($enlace, $sql);
    
    if (mysqli_num_rows($resultado)>0){
        $row = mysqli_fetch_assoc($resultado);

        $sql_insert = "INSERT INTO asistencia (fecha, horaEntrada, horaSalida, idEmpleado)VALUES ('{$row['fecha']}', '{$row['horaEntrada']}', '{$row['horaSalida']}', '{$row['idEmpleado']}')";
        mysqli_query($enlace, $sql_insert);

        // Elimina el registro de la tabla eliminados
        $sql_delete = "DELETE FROM asistencia_eliminada WHERE idAsistencia ='$idAsistencia'";
        mysqli_query($enlace, $sql_delete);
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'asist.php';
              </script>";;

    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de asistencia no proporcionado.";
}
?>