<?php 
include("db.php"); 

if (isset($_GET['idRol'])) {
    $idRol = $_GET['idRol'];

    $sql = "SELECT * FROM rol_eliminado WHERE idRol='$idRol'";
    $resultado = mysqli_query($enlace, $sql);
    
    if (mysqli_num_rows($resultado)>0){
        $row = mysqli_fetch_assoc($resultado);

        $sql_insert = "INSERT INTO rol (nombre,salarioBase) VALUES ('{$row['nombre']}', '{$row['salarioBase']}')";
        mysqli_query($enlace, $sql_insert);

        // Elimina el registro de la tabla eliminados
        $sql_delete = "DELETE FROM rol_eliminado WHERE idRol ='$idRol'";
        mysqli_query($enlace, $sql_delete);
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'rolconsul.php';
              </script>";;

    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de rol no proporcionado.";
}
?>