<?php
include("validar.php");
include("db.php");

if (isset($_GET['idEmpleado'])) {
    $idEmpleado = $_GET['idEmpleado'];

    $sql = "SELECT * FROM empleado WHERE idEmpleado=$idEmpleado";
    $result = mysqli_query($enlace, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sql_insert = "INSERT INTO empleado_eliminado (imagen, nombre, apellido, DNI, fechaNacimiento, direccion, telefono, email, fechaContratacion, salario, idOficina, idRol) VALUES ('{$row['imagen']}', '{$row['nombre']}', '{$row['apellido']}', '{$row['DNI']}', '{$row['fechaNacimiento']}', '{$row['direccion']}', '{$row['telefono']}', '{$row['email']}', '{$row['fechaContratacion']}', '{$row['salario']}', '{$row['idOficina']}', '{$row['idRol']}')";


        mysqli_query($enlace, $sql_insert);
        // Elimina el registro de la tabla principal
        $sql_delete = "DELETE FROM empleado WHERE idEmpleado = $idEmpleado";
        mysqli_query($enlace, $sql_delete);
        echo  "<script>
        alert('El registro se ha eliminado correctamente.');
        window.location.href = 'deleted.php';
      </script>";
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de empleado no proporcionado.";
}
?>