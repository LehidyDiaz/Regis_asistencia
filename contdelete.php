<?php
include("validar.php");
include("db.php");

if (isset($_GET['idContacto'])) {
    $idContacto = $_GET['idContacto'];

    $sql = "SELECT * FROM contactoemergencia WHERE idContacto=$idContacto";
    $result = mysqli_query($enlace, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sql_insert = "INSERT INTO  contacto_eliminado (nombre, relacion, telefono, direccion, idEmpleado)VALUES ('{$row['nombre']}', '{$row['relacion']}', '{$row['telefono']}',  '{$row['direccion']}', '{$row['idEmpleado']}')";


        mysqli_query($enlace, $sql_insert);
        // Elimina el registro de la tabla principal
        $sql_delete = "DELETE FROM contactoemergencia WHERE idContacto = $idContacto";
        mysqli_query($enlace, $sql_delete);
        echo  "<script>
        alert('El registro se ha eliminado correctamente.');
        window.location.href = 'deleted.php';
      </script>";
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de contactoemergencia no proporcionado.";
}
?>