<?php include("db.php");
$busqueda_personal = isset($_POST['busqueda_personal']) ? $_POST['busqueda_personal'] : '';
$busqueda_asistencia = isset($_POST['busqueda_asistencia']) ? $_POST['busqueda_asistencia'] : '';
$busqueda_oficina = isset($_POST['busqueda_oficina']) ? $_POST['busqueda_oficina'] : '';
$busqueda_rol = isset($_POST['busqueda_rol']) ? $_POST['busqueda_rol'] : '';
$busqueda_vacaciones = isset($_POST['busqueda_vacaciones']) ? $_POST['busqueda_vacaciones'] : '';
$busqueda_contacto = isset($_POST['busqueda_contacto']) ? $_POST['busqueda_contacto'] : '';
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
        <div class="text">Lista de Empleados eliminados
            <div class="consultar">
                <form action="deleted.php" method="post">
                    <input type="text" name="busqueda_personal" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda_personal); ?>">
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
                            <th>Oficina</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <?php
                    $sql_personal = "SELECT e.imagen, e.nombre, e.apellido, e.DNI, e.fechaNacimiento, e.direccion, e.telefono, e.email, e.fechaContratacion, e.salario, o.nombre AS nombre_oficina, r.nombre AS nombre_rol 
                                     FROM empleado_eliminado e 
                                     LEFT JOIN oficina o ON e.idOficina = o.idOficina 
                                     LEFT JOIN rol r ON e.idRol = r.idRol
                                     WHERE e.nombre LIKE '%$busqueda_personal%' 
                                        OR e.fechaContratacion LIKE '%$busqueda_personal%' 
                                        OR e.DNI LIKE '%$busqueda_personal%'";
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
                        echo "<td>{$row_personal['nombre_oficina']}</td>";
                        echo "<td>{$row_personal['nombre_rol']}</td>";
                        echo "<td><a href='restore.php?idEmpleado=" . $row_personal['idEmpleado'] . "' class='btn'>Restaurar</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>

            <div class="text">Asistencias eliminadas
                <div class="consultar">
                    <form action="deleted.php" method="post">
                        <input type="text" name="busqueda_asistencia" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda_asistencia); ?>">
                        <input type="submit" class="btn" value="Buscar"><br><br>
                    </form>
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                                <th>Empleado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <?php
                        $sql_asistencia = "SELECT a.fecha, a.horaEntrada, a.horaSalida, e.nombre AS nombre_empleado 
                                           FROM asistencia_eliminada a 
                                           LEFT JOIN empleado e ON a.idEmpleado = e.idEmpleado 
                                           WHERE a.fecha LIKE '%$busqueda_asistencia%'";
                        $resultado_asistencia = mysqli_query($enlace, $sql_asistencia);
                        while ($row_asistencia = mysqli_fetch_assoc($resultado_asistencia)) {
                            echo "<tr>";
                            echo "<td>{$row_asistencia['fecha']}</td>";
                            echo "<td>{$row_asistencia['horaEntrada']}</td>";
                            echo "<td>{$row_asistencia['horaSalida']}</td>";
                            echo "<td>{$row_asistencia['nombre_empleado']}</td>";
                            echo "<td><a href='asistrestore.php?idAsistencia=" . $row_asistencia['idAsistencia'] . "' class='btn'>Restaurar</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="text">Oficinas eliminadas
                <div class="consultar">
                    <form action="deleted.php" method="post">
                        <input type="text" name="busqueda_oficina" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda_oficina); ?>">
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
                        $sql_oficina = "SELECT nombre, telefono, fechaeli 
                                        FROM oficina_eliminado 
                                        WHERE nombre LIKE '%$busqueda_oficina%'";
                        $resultado_oficina = mysqli_query($enlace, $sql_oficina);

                        while ($row_oficina = mysqli_fetch_assoc($resultado_oficina)) {
                            echo "<tr>";
                            echo "<td>{$row_oficina['nombre']}</td>";
                            echo "<td>{$row_oficina['telefono']}</td>";
                            echo "<td>{$row_oficina['fechaeli']}</td>";
                            echo "<td><a href='deprestore.php?idOficina=" . $row_oficina['idOficina'] . "' class='btn'>Restaurar</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="text">Roles eliminados
                <div class="consultar">
                    <form action="deleted.php" method="post">
                        <input type="text" name="busqueda_rol" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda_rol); ?>">
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
                        $sql_rol = "SELECT nombre, salarioBase, fechaeli 
                                    FROM rol_eliminado 
                                    WHERE nombre LIKE '%$busqueda_rol%'";
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

            <div class="text">Vacaciones eliminadas
                <div class="consultar">
                    <form action="deleted.php" method="post">
                        <input type="text" name="busqueda_vacaciones" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda_vacaciones); ?>">
                        <input type="submit" class="btn" value="Buscar"><br><br>
                    </form>
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Empleado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <?php
                        $sql_vacaciones = "SELECT v.fechaInicio, v.fechaFin, e.nombre AS nombre_empleado 
                                           FROM vacaciones_eliminada v 
                                           LEFT JOIN empleado e ON v.idEmpleado = e.idEmpleado 
                                           WHERE v.fechaInicio LIKE '%$busqueda_vacaciones%'";
                        $resultado_vacaciones = mysqli_query($enlace, $sql_vacaciones);
                        while ($row_vacaciones = mysqli_fetch_assoc($resultado_vacaciones)) {
                            echo "<tr>";
                            echo "<td>{$row_vacaciones['fechaInicio']}</td>";
                            echo "<td>{$row_vacaciones['fechaFin']}</td>";
                            echo "<td>{$row_vacaciones['nombre_empleado']}</td>";
                            echo "<td><a href='vacacionesrestore.php?idVacaciones=" . $row_vacaciones['idVacaciones'] . "' class='btn'>Restaurar</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="text">Contactos de emergencia eliminados
                <div class="consultar">
                    <form action="deleted.php" method="post">
                        <input type="text" name="busqueda_contacto" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda_contacto); ?>">
                        <input type="submit" class="btn" value="Buscar"><br><br>
                    </form>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Relación</th>
                                <th>Telefono</th>
                                <th>Empleado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <?php
                        $sql_contacto = "SELECT c.nombre, c.relacion, c.telefono, e.nombre AS nombre_empleado 
                                         FROM contacto_eliminado c 
                                         LEFT JOIN empleado e ON c.idEmpleado = e.idEmpleado 
                                         WHERE c.nombre LIKE '%$busqueda_contacto%'";
                        $resultado_contacto = mysqli_query($enlace, $sql_contacto);
                        while ($row_contacto = mysqli_fetch_assoc($resultado_contacto)) {
                            echo "<tr>";
                            echo "<td>{$row_contacto['nombre']}</td>";
                            echo "<td>{$row_contacto['relacion']}</td>";
                            echo "<td>{$row_contacto['telefono']}</td>";
                            echo "<td>{$row_contacto['nombre_empleado']}</td>";
                            echo "<td><a href='contactrestore.php?idContacto=" . $row_contacto['idContacto'] . "' class='btn'>Restaurar</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <script>
        const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle");

        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        })
    </script>
</body>

</html>