<?php include("db.php");
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
?>
<?php
include("validar.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Consultar Personal</title>
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
                    <a href="goog.php">
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
        <div class="text">Lista de Empleados eliminado
            <div class="consultar">
                <form action="deleted.php" method="post">
                    <input type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    <input type="submit" class="btn" value="Buscar"><br><br>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>DNI</th>
                            <th>Fecha Nacimiento</th>
                            <th>Dirección</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Fecha de Contratación</th>
                            <th>Salario</th>
                            <th>Id Oficina</th>
                            <th>Id Posición</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <?php
                    $sql_personal = "SELECT * FROM empleado_eliminado WHERE nombre LIKE '%$busqueda%' OR fechaContratacion LIKE '%$busqueda%' OR DNI LIKE '%$busqueda%'";
                    $resultado_personal = mysqli_query($enlace, $sql_personal);

                    while ($row_personal = mysqli_fetch_assoc($resultado_personal)) {
                        echo "<tr>";
                        echo "<td>{$row_personal['imagen']}</td>";
                        echo "<td>{$row_personal['nombre']}</td>";
                        echo "<td>{$row_personal['apellido']}</td>";
                        echo "<td>{$row_personal['DNI']}</td>";
                        echo "<td>{$row_personal['fechaNacimiento']}</td>";
                        echo "<td>{$row_personal['direccion']}</td>";
                        echo "<td>{$row_personal['telefono']}</td>";
                        echo "<td>{$row_personal['email']}</td>";
                        echo "<td>{$row_personal['fechaContratacion']}</td>";
                        echo "<td>{$row_personal['salario']}</td>";
                        echo "<td>{$row_personal['idOficina']}</td>";
                        echo "<td>{$row_personal['idRol']}</td>";
                        echo "<td><a href='restore.php? idEmpleado=" . $row_personal['idEmpleado'] . " 'class='btn'>Restaurar</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="vacaciones">
                        <div class="text">Asistencias eliminadas
                            <div class="consultar">
                                <form action="deleted.php" method="post">
                                    <input type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                                    <input type="submit" class="btn" value="Buscar"><br><br>
                                </form>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora Entrada</th>
                                            <th>Hora Salida</th>
                                            <th>iD Empleado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $sql_asistencia = "SELECT * FROM asistencia_eliminada WHERE fecha LIKE '%$busqueda%'";
                                    $resultado_asistencia = mysqli_query($enlace, $sql_asistencia);
                                    while ($row_asistencia = mysqli_fetch_assoc($resultado_asistencia)) {
                                        echo "<tr>";
                                        echo "<td>{$row_asistencia['fecha']}</td>";
                                        echo "<td>{$row_asistencia['horaEntrada']}</td>";
                                        echo "<td>{$row_asistencia['horaSalida']}</td>";
                                        echo "<td>{$row_asistencia['idEmpleado']}</td>";
                                        echo "<td><a href='asistrestore.php?idAsistencia=" . $row_asistencia['idAsistencia'] . "' class='btn'>Restaurar</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
            <div class="contac">
                <div class="text">Oficinas eliminados
                    <div class="consultar">
                        <form action="deleted.php" method="post">
                            <input type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                            <input type="submit" class="btn" value="Buscar"><br><br>
                        </form>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Fecha de eliminación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <?php
                            $sql_oficina = "SELECT * FROM oficina_eliminado WHERE nombre LIKE '%$busqueda%'";
                            $resultado_oficina = mysqli_query($enlace, $sql_oficina);

                            while ($row_oficina = mysqli_fetch_assoc($resultado_oficina)) {
                                echo "<tr>";
                                echo "<td>{$row_oficina['nombre']}</td>";
                                echo "<td>{$row_oficina['telefono']}</td>";
                                echo "<td>{$row_oficina['fechaeli']}</td>";
                                echo "<td><a href='deprestore.php?idOficina=" . $row_oficina['idOficina'] . "' class='btn' >Restaurar</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="rol">
                    <div class="text">Roles eliminados
                        <div class="consultar">
                            <form action="deleted.php" method="post">
                                <input type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                                <input type="submit" class="btn" value="Buscar"><br><br>
                            </form>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Salario Base</th>
                                        <th>Fecha de eliminación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql_rol = "SELECT * FROM rol_eliminado WHERE nombre LIKE '%$busqueda%'";
                                $resultado_rol = mysqli_query($enlace, $sql_rol);
                                while ($row_rol = mysqli_fetch_assoc($resultado_rol)) {
                                    echo "<tr>";
                                    echo "<td>{$row_rol['nombre']}</td>";
                                    echo "<td>{$row_rol['salarioBase']}</td>";
                                    echo "<td>{$row_rol['fechaeli']}</td>";
                                    echo "<td><a href='rolrestore.php?idRol=" . $row_rol['idRol'] . "' class='btn'>Restaurar</a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                    <div class="vacaciones">
                        <div class="text">Vacaciones eliminadas
                            <div class="consultar">
                                <form action="deleted.php" method="post">
                                    <input type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                                    <input type="submit" class="btn" value="Buscar"><br><br>
                                </form>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Motivo</th>
                                            <th>iD Empleado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $sql_vaca = "SELECT * FROM vacaciones_eliminada WHERE fechaInicio LIKE '%$busqueda%'";
                                    $resultado_vaca = mysqli_query($enlace, $sql_vaca);
                                    while ($row_vaca = mysqli_fetch_assoc($resultado_vaca)) {
                                        echo "<tr>";
                                        echo "<td>{$row_vaca['fechaInicio']}</td>";
                                        echo "<td>{$row_vaca['fechaFin']}</td>";
                                        echo "<td>{$row_vaca['motivo']}</td>";
                                        echo "<td>{$row_vaca['idEmpleado']}</td>";
                                        echo "<td><a href='vacrestore.php?idVacaciones=" . $row_vaca['idVacaciones'] . "' class='btn'>Restaurar</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="Contac_Emergencia">
                        <div class="text">Contacto de emergencia eliminadas
                            <div class="consultar">
                                <form action="deleted.php" method="post">
                                    <input type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                                    <input type="submit" class="btn" value="Buscar"><br><br>
                                </form>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Relación</th>
                                            <th>Teléfono</th>
                                            <th>Dirección</th>
                                            <th>iD Empleado</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <?php
                                    $sql_contac= "SELECT * FROM contacto_eliminado WHERE idEmpleado LIKE '%$busqueda%'";
                                    $resultado_contac = mysqli_query($enlace, $sql_contac);
                                    while ($row_contac = mysqli_fetch_assoc($resultado_contac)) {
                                        echo "<tr>";
                                        echo "<td>{$row_contac['nombre']}</td>";
                                        echo "<td>{$row_contac['relacion']}</td>";
                                        echo "<td>{$row_contac['telefono']}</td>";
                                        echo "<td>{$row_contac['direccion']}</td>";
                                        echo "<td>{$row_contac['idEmpleado']}</td>";
                                        echo "<td><a href='contrestore.php?idContacto=" . $row_contac['idContacto'] . "' class='btn' >Restaurar</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
    </section>

    <script src="script.js"></script>
</body>

</html>