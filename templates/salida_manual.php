<?php
include("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    // Buscar el ID del empleado usando el nombre
    $sql_empleado = "SELECT idEmpleado FROM empleado WHERE nombre = ?";
    $stmt_empleado = $enlace->prepare($sql_empleado);
    $stmt_empleado->bind_param("s", $nombre);
    $stmt_empleado->execute();
    $result_empleado = $stmt_empleado->get_result();

    if ($result_empleado->num_rows > 0) {
        $row = $result_empleado->fetch_assoc();
        $id_empleado = $row['idEmpleado'];

        // Obtener la hora de salida actual
        $hora_salida = date("H:i:s");
        $fecha_actual = date("Y-m-d");

        // Actualizar la hora de salida en el registro más reciente del empleado donde la hora de salida es NULL
        $sql_asistencia = "UPDATE asistencia SET horaSalida = ? WHERE idEmpleado = ? AND fecha = ? AND horaSalida IS NULL ORDER BY horaEntrada DESC LIMIT 1";
        $stmt_asistencia = $enlace->prepare($sql_asistencia);
        $stmt_asistencia->bind_param("sis", $hora_salida, $id_empleado, $fecha_actual);

        if ($stmt_asistencia->execute()) {
            echo "<script>
                    alert('Salida registrada correctamente.');
                    window.location.href = '../index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al registrar la salida: " . $stmt_asistencia->error . "');
                    window.location.href = 'salida_manual.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Registre su asistencia:');
                window.location.href = 'salida_manual.php';
              </script>";
    }


    $stmt_empleado->close();
    $stmt_asistencia->close();
    $enlace->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Salida Manual - Nexus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .input-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .button {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            background-color: #507bff;
            color: white;
            cursor: pointer;
            margin-top: 20px;
        }
        .button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrar Salida Manual</h1>
        <form action="salida_manual.php" method="post">
            <div class="input-group">
                <label for="nombre">Selecciona tu nombre:</label>
                <select name="nombre" id="nombre" required>
                    <option value="">Seleccione su nombre</option>
                    <?php
                    // Obtener los empleados que han registrado su asistencia el mismo día
                    $fecha_actual = date("Y-m-d");
                    $sql_nombres = "SELECT DISTINCT e.nombre 
                                    FROM empleado e 
                                    JOIN asistencia a ON e.idEmpleado = a.idEmpleado 
                                    WHERE a.fecha = ? AND a.horaSalida IS NULL";
                    $stmt_nombres = $enlace->prepare($sql_nombres);
                    $stmt_nombres->bind_param("s", $fecha_actual);
                    $stmt_nombres->execute();
                    $result_nombres = $stmt_nombres->get_result();

                    while ($row = $result_nombres->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['nombre']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                    }

                    $stmt_nombres->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="button">Registrar Salida</button>
        </form>
    </div>
</body>
</html>
