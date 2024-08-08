<?php 
include("db.php"); 

if (isset($_GET['idOficina'])) {
    $idOficina = $_GET['idOficina'];

    $sql = "SELECT * FROM oficina_eliminado WHERE idOficina='$idOficina'";
    $resultado = mysqli_query($enlace, $sql);
    
    if (mysqli_num_rows($resultado)>0){
        $row = mysqli_fetch_assoc($resultado);

        $sql_insert = "INSERT INTO oficina (nombre,telefono) VALUES ('{$row['nombre']}', '{$row['telefono']}')";
        mysqli_query($enlace, $sql_insert);

        // Elimina el registro de la tabla eliminados
        $sql_delete = "DELETE FROM oficina_eliminado WHERE idOficina ='$idOficina'";
        mysqli_query($enlace, $sql_delete);
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'depconsul.php';
              </script>";;

    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de oficina no proporcionado.";
}
?>