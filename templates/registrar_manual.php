<?php
include("../db.php");

// Inicializar variables para mensajes
$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (isset($_POST['idEmpleado']) && !empty($_POST['idEmpleado'])) {
       
        $id_empleado = intval($_POST['idEmpleado']);
        $fecha = date("Y-m-d");
        $hora_entrada = date("H:i:s");
    
        
        $stmt = $enlace->prepare("INSERT INTO asistencia (fecha, horaEntrada, idEmpleado) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $fecha, $hora_entrada, $id_empleado);
    
        if ($stmt->execute()) {
            $message = "Asistencia registrada exitosamente para el empleado con ID: $id_empleado.";
            echo "<script>
            alert('Registro subido correctamente.');
            window.location.href = '../index.php';
          </script>";
            $message_type = "success";
        } else {
            $message = "Error al registrar la asistencia: " . $stmt->error;
            $message_type = "error";
        }
    
        $stmt->close();
    } else {
        $message = "Por favor, seleccione un empleado antes de registrar la asistencia.";
        $message_type = "warning";
    }
}

// Obtener todos los nombres y apellidos de los empleados
$sql = "SELECT idEmpleado, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM empleado ORDER BY nombre, apellido";
$resultado = mysqli_query($enlace, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia</title>
    <!-- Puedes agregar estilos CSS aquí para mejorar la presentación -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .success {
            background-color: #c8e6c9;
            color: #256029;
        }
        .error {
            background-color: #ffcdd2;
            color: #c63737;
        }
        .warning {
            background-color: #ffecb3;
            color: #795548;
        }
        form {
            margin-bottom: 20px;
        }
        label, select, input[type="submit"] {
            display: block;
            margin-bottom: 10px;
        }
        select, input[type="submit"] {
            padding: 5px;
            width: 200px;
        }
    </style>
</head>
<body>

<h2>Registro de Asistencia</h2>

<?php
// Mostrar mensaje si existe
if (!empty($message)) {
    echo "<div class='message $message_type'>$message</div>";
}
?>

<form action="" method="post">
    <label for="empleado">Seleccione su nombre:</label>
    <select name="idEmpleado" id="empleado" required>
        <option value="">-- Seleccione su nombre --</option>
        <?php
        // Llenar el select con los nombres completos de los empleados
        while ($row = mysqli_fetch_assoc($resultado)) {
            // Mantener la selección después de enviar el formulario
            $selected = (isset($_POST['idEmpleado']) && $_POST['idEmpleado'] == $row['idEmpleado']) ? 'selected' : '';
            echo "<option value='{$row['idEmpleado']}' $selected>{$row['nombre_completo']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="Registrar Asistencia">
</form>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$enlace->close();
?>
