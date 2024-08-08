<?php
include("validar.php");
include("db.php");

if (isset($_GET['idOficina'])) {
    $idOficina = $_GET['idOficina'];

    $sql = "SELECT * FROM oficina WHERE idOficina=$idOficina";
    $result = mysqli_query($enlace, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
      
        $sql_insert = "INSERT INTO oficina_eliminado (nombre,telefono, fechaeli) VALUES ('{$row['nombre']}', '{$row['telefono']}', now())";

        mysqli_query($enlace, $sql_insert);
        // Elimina el registro de la tabla principal
        $sql_delete = "DELETE FROM oficina WHERE idOficina=$idOficina";
        mysqli_query($enlace, $sql_delete);
        echo  "<script>
        alert('El registro se ha eliminado correctamente.');
        window.location.href = 'deleted.php';
      </script>";
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de Oficina no proporcionado.";
}
?>
