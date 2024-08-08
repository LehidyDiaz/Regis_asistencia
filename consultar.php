<?php include("db.php");
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';


include("validar.php");
include("validation.php");

echo $_SESSION["user"];
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
        <div class="text">Lista de Empleados
        <div class="consultar">
                <form action="consultar.php" method="post">
                    <input type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    <input type="submit" value="Buscar" class="btn"><br><br>
                </form>
                <a href='vacexport.php?busqueda=<?php echo htmlspecialchars($busqueda); ?>'>
                    <input type="button" class="btn" value="Descargar">
                </a>
                <div class="crear">
                    <a href='create.php'>
                        <input type="submit" class="btn" value="Nuevo empleado"> <br></br>
                    </a>
                </div>
                <style>
                    .imagen-pequena {
                        width: 80px;
                        height: auto;
                    }
                </style>
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
                    $sql = "SELECT * FROM empleado WHERE nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' OR DNI LIKE '%$busqueda%'";
                    $resultado = mysqli_query($enlace, $sql);

                    while ($row = mysqli_fetch_assoc($resultado)) {
                        $imagen = $row["imagen"];
                        echo "<tr>";
                        echo "<td><img src='$imagen'class='imagen-pequena'></td>";
                        echo "<td>{$row['nombre']}</td>";
                        echo "<td>{$row['apellido']}</td>";
                        echo "<td>{$row['DNI']}</td>";
                        echo "<td>{$row['fechaNacimiento']}</td>";
                        echo "<td>{$row['direccion']}</td>";
                        echo "<td>{$row['telefono']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['fechaContratacion']}</td>";
                        echo "<td>{$row['salario']}</td>";
                        echo "<td>{$row['idOficina']}</td>";
                        echo "<td>{$row['idRol']}</td>";

                        echo "<td><a href='update.php?idEmpleado={$row['idEmpleado']}' class='btn'>Editar</a>
                        <a href='delete.php?idEmpleado={$row['idEmpleado']}' class='btn'>Borrar</a>
                      </td>";
                        echo "</tr>";
                    }
                    ?>

                </table>

    </section>
    <script src="script.js"></script>
</body>

</html>