<?php
include("validar.php");
include("db.php");

if (isset($_GET['idEmpleado'])) {
    $idEmpleado  = $_GET['idEmpleado'];
    $sql = "SELECT * FROM empleado WHERE idEmpleado=$idEmpleado";
    $result = mysqli_query($enlace, $sql);
    $employee = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $idEmpleado = $_POST['idEmpleado'];
    $image = $_FILES['imagen']['name'];
    $target = "uploads/" . basename($image);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $DNI = $_POST['DNI'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $fechaContratacion = $_POST['fechaContratacion'];
    $salario = $_POST['salario'];
    $idOficina = $_POST['idOficina'];
    $idRol = $_POST['idRol'];

    if (empty($image)) {
        $sql = "UPDATE empleado SET nombre='$nombre', apellido='$apellido', DNI='$DNI', fechaNacimiento='$fechaNacimiento', direccion='$direccion', telefono='$telefono', email='$email', fechaContratacion='$fechaContratacion', salario='$salario', idOficina='$idOficina', idRol='$idRol' WHERE idEmpleado=$idEmpleado";
    } else {
        $sql = "UPDATE empleado SET imagen='$target', nombre='$nombre', apellido='$apellido', DNI='$DNI', fechaNacimiento='$fechaNacimiento', direccion='$direccion', telefono='$telefono', email='$email', fechaContratacion='$fechaContratacion', salario='$salario', idOficina='$idOficina', idRol='$idRol' WHERE idEmpleado=$idEmpleado";
        move_uploaded_file($_FILES['imagen']['tmp_name'], $target);
    }

    if (mysqli_query($enlace, $sql)) {
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'consultar.php';
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
    <title>Actualizar empleado</title>
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
                            <span class="text nav-text">Oficina</span>
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
        <div class="text">Bienvenido :D</div>
    </section>

    <section class="home">
        <div class="text">Actualizar empleado
            <div class="consultar">
                <form action="update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idEmpleado" value="<?php echo $employee['idEmpleado']; ?>">
                    <label for="imagen">Foto:</label>
                    <input type="file" id="imagen" name="imagen"><br>
                    <label for="nombre">Nombres:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $employee['nombre']; ?>" required><br>
                    <label for="apellido">Apellidos:</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo $employee['apellido']; ?>" required><br>
                    <label for="DNI">DNI:</label>
                    <input type="text" id="DNI" name="DNI" value="<?php echo $employee['DNI']; ?>" required><br>
                    <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $employee['fechaNacimiento']; ?>"><br>
                    <label for="direccion">Direccion:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo $employee['direccion']; ?>"><br>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo $employee['telefono']; ?>"><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $employee['email']; ?>" required><br>
                    <label for="fechaContratacion">Fecha de Contratación:</label>
                    <input type="date" id="fechaContratacion" name="fechaContratacion" value="<?php echo $employee['fechaContratacion']; ?>"><br>
                    <label for="salario">Salario:</label>
                    <input type="text" id="salario" name="salario" value="<?php echo $employee['salario']; ?>" required><br>

                    <label for="idOficina">ID Oficina:</label>
                    <select id="idOficina" name="idOficina" required onchange="mostrarDetallesOficina(this.value)">
                    <?php
                        $query = "SELECT idOficina, nombre, telefono FROM oficina";
                        $result = mysqli_query($enlace, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['idOficina'] == $employee['idOficina']) ? 'selected' : '';
                            echo "<option value='" . $row['idOficina'] . "' $selected>" . $row['nombre'] . "</option>";
                        }
                    ?>
                    </select><br>
                    <div id="detallesOficina"></div>

                    <label for="idRol">ID Rol:</label>
                    <select id="idRol" name="idRol" required onchange="mostrarDetallesPosicion(this.value)">
                    <?php
                        $query = "SELECT idRol, nombre, salarioBase FROM rol";
                        $result = mysqli_query($enlace, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['idRol'] == $employee['idRol']) ? 'selected' : '';
                            echo "<option value='" . $row['idRol'] . "' $selected>" . $row['nombre'] . "</option>";
                        }
                    ?>
                    </select><br>
                    <div id="detallesPosicion"></div>

                    <input type="submit" name="update" class="btn" value="Actualizar">
                </form>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
    <script>
        function mostrarDetallesOficina(idOficina) {
            if (idOficina == "") {
                document.getElementById("detallesOficina").innerHTML = "";
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("detallesOficina").innerHTML = this.responseText;
                }
            };
            xhr.open("GET", "obtenerDetallesOficina.php?idOficina=" + idOficina, true);
            xhr.send();
        }

        function mostrarDetallesPosicion(idRol) {
            if (idRol == "") {
                document.getElementById("detallesPosicion").innerHTML = "";
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("detallesPosicion").innerHTML = this.responseText;
                }
            };
            xhr.open("GET", "obtenerDetallesPosicion.php?idRol=" + idRol, true);
            xhr.send();
        }
    </script>
</body>
</html>
