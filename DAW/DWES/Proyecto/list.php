<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Comprobamos que el usuario está logueado
if (!isset($_SESSION['user'])) header('Location: index.php');

// Selecciona todas las revels del usuario
$consulta = $conexion->prepare('SELECT * FROM revels WHERE userid = ?;');
$consulta->execute([$_SESSION['id']]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIST Revels | Ismael</title>
</head>

<body>
    <h1>LIST Revels | Ismael</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($revel = $consulta->fetch()) : ?>
                <tr>
                    <td><?= $revel['id'] ?></td>
                    <td><?= $revel['texto'] ?></td>
                    <td><?= $revel['fecha'] ?></td>
                    <td>
                        <a href="delete.php?id=<?= $revel['id'] ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>