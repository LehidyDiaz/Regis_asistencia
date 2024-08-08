<?php include("db.php");
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
?>
<?php

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
        <div class="text">Lista de Roles
            <div class="consultar">
                <form action="rolconsul.php" method="post">
                    <input type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    <input type="submit" class="btn" value="Buscar"><br></br>
                </form>
                <div class="crear">
                    <a href='rolcreate.php'>
                        <input type="submit" class="btn" value="Nuevo rol"> <br></br>
                    </a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Rol</th>
                            <th>Salario Base</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <?php
                    $sql = "SELECT * FROM rol WHERE nombre LIKE '%$busqueda%'";
                    $resultado = mysqli_query($enlace, $sql);

                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<td>{$row['nombre']}</td>";
                        echo "<td>{$row['salarioBase']}</td>";

                        echo "<td><a href='rolupdate.php?idRol={$row['idRol']}' class='btn'>Editar</a>
                        <a href='roldelete.php?idRol={$row['idRol']}' class='btn'>Borrar</a>";
                        echo "</tr>";
                    }
                    ?>
                </table>

    </section>
    <script src="script.js"></script>
</body>

</html>