<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';

// Si el usuario no es admin, lo redirigimos a la página de inicio
if (!isset($_SESSION['admin'])) header('Location: index.php');

// Volvemos a validar que el usuario sea admin mediante la variable de sesión
// y una consulta a la base de datos
$validar = $conexion->prepare('SELECT rol FROM usuarios WHERE usuario = ?;');
$validar->execute([$_SESSION['admin']]);
$validar = $validar->fetch()['rol'];

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
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require_once 'include/header.inc.php'; ?>
    <main class="main__container">
        <h1>Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Token</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $consultaUsuarios->fetch()) : ?>
                    <tr>
                        <td><?= $usuario['usuario'] ?></td>
                        <td><?= $usuario['contrasenya'] ?></td>
                        <td><?= $usuario['rol'] ?></td>
                        <td><?= $usuario['token'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>

</html>