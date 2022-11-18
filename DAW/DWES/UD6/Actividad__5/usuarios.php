<?php
require_once 'include/dbconnection.inc.php';
session_start();

if (!isset($_SESSION['user'])) header('Location: index.php');

$validar = $conexion->query('SELECT rol FROM usuarios WHERE usuario LIKE ' . $_SESSION['usuario']);

if ($validar != 'admin') header('Location: index.php');

// Crea una consulta que muestre todos los usuarios registrados
$consultaUsuarios = $conexion->query('SELECT * FROM usuarios');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop USUARIOS | Ismael</title>
</head>

<body>
    <?php require_once 'include/header.inc.php'; ?>
    <main class="main__container">
        <h1>Usuarios</h1>
        <div class="usuarios__container">
            <?php
            // Muestra los usuarios
            while ($usuario = $consultaUsuarios->fetch()) {
                echo '<div class="usuario col-s-5 col-3">';
                echo '<p>' . $usuario['usuario'] . '</p>';
                echo '<p>' . $usuario['email'] . '</p>';
                echo '<p>' . $usuario['rol'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>

</html>