<?php 
include("db.php"); 

if (isset($_GET['idEmpleado'])) {
    $idEmpleado = $_GET['idEmpleado'];

    $sql = "SELECT * FROM empleado_eliminado WHERE idEmpleado='$idEmpleado'";
    $resultado = mysqli_query($enlace, $sql);
    
    if (mysqli_num_rows($resultado)>0){
        $row = mysqli_fetch_assoc($resultado);

        $sql_insert = "INSERT INTO empleado (imagen, nombre, apellido, DNI, fechaNacimiento, direccion, telefono, email, fechaContratacion, salario, idOficina, idRol) VALUES ('{$row['imagen']}', '{$row['nombre']}', '{$row['apellido']}', '{$row['DNI']}', '{$row['fechaNacimiento']}', '{$row['direccion']}', '{$row['telefono']}', '{$row['email']}', '{$row['fechaContratacion']}', '{$row['salario']}', '{$row['idOficina']}', '{$row['idRol']}')";
        mysqli_query($enlace, $sql_insert);

        // Elimina el registro de la tabla eliminados
        $sql_delete = "DELETE FROM empleado_eliminado WHERE idEmpleado ='$idEmpleado'";
        mysqli_query($enlace, $sql_delete);
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'consultar.php';
              </script>";;

    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de empleado no proporcionado.";
}
?>