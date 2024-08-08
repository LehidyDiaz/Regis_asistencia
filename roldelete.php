<?php
include("validar.php");
include("db.php");

if (isset($_GET['idRol'])) {
    $idRol = $_GET['idRol'];

    $sql = "SELECT * FROM rol WHERE idRol=$idRol";
    $result = mysqli_query($enlace, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
      
        $sql_insert = "INSERT INTO rol_eliminado (nombre,salarioBase, fechaeli) VALUES ('{$row['nombre']}', '{$row['salarioBase']}', now())";

        mysqli_query($enlace, $sql_insert);
        // Elimina el registro de la tabla principal
        $sql_delete = "DELETE FROM rol WHERE idRol=$idRol";
        mysqli_query($enlace, $sql_delete);
        echo  "<script>
        alert('El registro se ha eliminado correctamente.');
        window.location.href = 'deleted.php';
      </script>";
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de rol no proporcionado.";
}
?>
