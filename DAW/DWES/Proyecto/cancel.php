<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Comprobamos que el usuario está logueado
if (!isset($_SESSION['user'])) header('Location: index.php');

// Comprobamos que la id recibida es del usuario logueado
if ($_GET['id'] != $_SESSION['id']) header('Location: index.php');

// Si no recbeimos la id del usuario, redirigimos a index.php
if (!isset($_GET['id'])) header('Location: index.php');

/*
    si no recibe datos mostrará un formulario con un aviso de confirmación de
    eliminación de la cuenta con un checkbox y un botón para aceptar. Si se pulsa el
    botón de aceptar se enviarán los datos a la propia página. Si se reciben los datos
    del formulario de confirmación se eliminará al usuario, sus revelaciones y los
    comentarios a estas y se cerrará la sesión y redirigirá a la página index.
*/
if (isset($_POST['confirm'])) :
    $consulta = $conexion->prepare('DELETE FROM comments WHERE userid = ?;');
    $consulta->execute([$_GET['id']]);
    $consulta = $conexion->prepare('DELETE FROM revels WHERE userid = ?;');
    $consulta->execute([$_GET['id']]);
    $consulta = $conexion->prepare('DELETE FROM follows WHERE userid = ?;');
    $consulta->execute([$_GET['id']]);
    $consulta = $conexion->prepare('DELETE FROM users WHERE id = ?;');
    $consulta->execute([$_GET['id']]);
    session_destroy();
    header('Location: index.php');
else :
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ELIMINAR Revels | Ismael</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" href="img/ICONO-NEGATIVO.svg" type="image/x-icon">
    </head>

    <body class="back-end">
        <div class="header">
            <div class="revels-icon">
                <h2 id="headerh2"><a href="index.php"><img src="img/ICONO-NEGATIVO.svg" alt="Icono Revels">REVELS</a></h2>
            </div>
            <div class="account">
                <a href="account.php"><img src="img/Profile.svg" alt="Perfil"></a>
            </div>
            <div class="logout">
                <a href="logout.php"><img src="img/Logout.svg" alt="Cerrar Sesión"></a>
            </div>
        </div>
        <div class="content">
            <h1>¿Estás seguro de que quieres eliminar tu cuenta?</h1>
            <form action="cancel.php?id=<?= $_GET['id'] ?>" method="post">
                <label for="confirm"><input type="checkbox" name="confirm" id="confirm" required>Confirmo que quiero eliminar mi cuenta</label>
                <input type="submit" value="Eliminar">
            </form>
        </div>
    </body>

    </html>
<?php endif; ?>