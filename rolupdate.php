<?php
include("validar.php");
include("db.php");

if (isset($_GET['idRol'])) {
    $idRol  = $_GET['idRol'];
    $sql = "SELECT * FROM rol WHERE idRol=$idRol ";
    $result = mysqli_query($enlace, $sql);
    $employee = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $idRol = $_POST['idRol'];
    $nombre = $_POST['nombre'];
    $salarioBase = $_POST['salarioBase'];


    $sql = "UPDATE rol SET nombre='$nombre', salarioBase='$salarioBase' WHERE idRol=$idRol";

    if (mysqli_query($enlace, $sql)) {
        echo "<script>
                alert('El registro se ha actualizado correctamente.');
                window.location.href = 'rolconsul.php';
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
    <title>Actualizar rol</title>
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
                            <span class="text nav-text">rol</span>
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
        <div class="text">Bienvenido :D</div>
    </section>

    <section class="home">
        <div class="text">Actualizar rol
            <div class="consultar">
                <form action="rolupdate.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idRol" value="<?php echo $employee['idRol']; ?>">
                    <label for="nombre">rol:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $employee['nombre']; ?>" required><br>
                    <label for="salarioBase">salarioBase:</label>
                    <input type="text" id="salarioBase" name="salarioBase" value="<?php echo $employee['salarioBase']; ?>" required><br>
                    
                    <input type="submit" name="update" class="btn" value="Actualizar">
                </form>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>

</html>