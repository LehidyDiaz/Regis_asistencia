<?php
include("validar.php");
include("db.php");

if (isset($_GET['idVacaciones'])) {
    $idVacaciones  = $_GET['idVacaciones'];
    $sql = "SELECT * FROM vacaciones WHERE idVacaciones=$idVacaciones";
    $result = mysqli_query($enlace, $sql);
    $employee = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $idVacaciones = $_POST['idVacaciones'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $motivo = $_POST['motivo'];
    $idEmpleado = $_POST['idEmpleado'];
   
        $sql = "UPDATE vacaciones SET fechaInicio='$fechaInicio', fechaFin='$fechaFin', motivo='$motivo', idEmpleado='$idEmpleado' WHERE idVacaciones=$idVacaciones";


    if (mysqli_query($enlace, $sql)) {
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'vacconsul.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($enlace);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Actualizar vacaciones</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="logo.png" alt="logo">
                </span>
                <div class="text header-text">
                    <span class="name">Empresa - Nexus</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-links">
                        <a href="consultar.php">
                        <i class='bx bxs-user-account icon'></i>
                            <span class="text nav-text">Empleados</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="asist.php">
                            <i class='bx bx-user-check icon'></i>
                            <span class="text nav-text">Asistencia</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="depconsul.php">
                        <i class='bx bx-buildings icon'></i>
                            <span class="text nav-text">Empleado</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="rolconsul.php">
                        <i class='bx bxs-user-detail icon'></i>
                            <span class="text nav-text">Rol - Cargos</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="contconsul.php">
                            <i class='bx bxs-ambulance icon'></i>
                            <span class="text nav-text">Contacto emergencia</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="vacconsul.php">
                            <i class='bx bxs-plane-alt icon'></i>
                            <span class="text nav-text">Vacaciones</span>
                        </a>
                    </li>
                    <li class="nav-links">
                        <a href="deleted.php">
                            <i class='bx bx-trash-alt icon'></i>
                            <span class="text nav-text">Papelera</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="index.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Salir</span>
                    </a>
                </li>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>

    <section class="home">
        <div class="text">Actualizar vacaciones
            <div class="consultar">
                <form action="vacupdate.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idVacaciones" value="<?php echo $employee['idVacaciones']; ?>">
                    <label for="fechaInicio">fechaInicios:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo $employee['fechaInicio']; ?>" required><br>
                    <label for="fechaFin">Fecha Fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" value="<?php echo $employee['fechaFin']; ?>" required><br>
                    <label for="motivo">motivo:</label>
                    <input type="text" id="motivo" name="motivo" value="<?php echo $employee['motivo']; ?>" required><br>

                    <label for="idEmpleado">ID Empleado:</label>
                    <select id="idEmpleado" name="idEmpleado" required onchange="mostrarDetallesEmpleado(this.value)">
                    <?php
                        $query = "SELECT idEmpleado, nombre, apellido, telefono, fechaContratacion FROM empleado";
                        $result = mysqli_query($enlace, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['idEmpleado'] == $employee['idEmpleado']) ? 'selected' : '';
                            echo "<option value='" . $row['idEmpleado'] . "' $selected>" . $row['nombre'] . "</option>";
                        }
                    ?>
                    </select><br>
                    <div id="detallesEmpleado"></div>

                    <input type="submit" name="update" class="btn" value="Actualizar">
                </form>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
    <script>
        function mostrarDetallesEmpleado(idEmpleado) {
            if (idEmpleado == "") {
                document.getElementById("detallesEmpleado").innerHTML = "";
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("detallesEmpleado").innerHTML = this.responseText;
                }
            };
            xhr.open("GET", "obtenerDetallesEmpleado.php?idEmpleado=" + idEmpleado, true);
            xhr.send();
        }
    </script>
</body>
</html>
