<?php
$servidor = "localhost";
$usuario = "root";
$clave = "Pame0805.";
$baseDeDatos = "empleadon";

$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);
if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>