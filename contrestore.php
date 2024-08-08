<?php 
include("db.php"); 

if (isset($_GET['idContacto'])) {
    $idContacto = $_GET['idContacto'];

    $sql = "SELECT * FROM contacto_eliminado WHERE idContacto='$idContacto'";
    $resultado = mysqli_query($enlace, $sql);
    
    if (mysqli_num_rows($resultado)>0){
        $row = mysqli_fetch_assoc($resultado);

        $sql_insert = "INSERT INTO contactoemergencia (nombre, relacion, telefono, direccion, idEmpleado)VALUES ('{$row['nombre']}', '{$row['relacion']}', '{$row['telefono']}', '{$row['direccion']}', '{$row['idEmpleado']}')";
        mysqli_query($enlace, $sql_insert);

        // Elimina el registro de la tabla eliminados
        $sql_delete = "DELETE FROM contacto_eliminado WHERE idContacto ='$idContacto'";
        mysqli_query($enlace, $sql_delete);
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'contconsul.php';
              </script>";;

    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de contacto no proporcionado.";
}
?>