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
    // Eliminamos al usuario
    $conexion->query('DELETE FROM users WHERE id = ' . $_GET['id'] . ';');
    // Eliminamos las revelaciones del usuario
    $conexion->query('DELETE FROM revels WHERE userid = ' . $_GET['id'] . ';');
    // Eliminamos los comentarios de las revelaciones borradas
    $conexion->query('DELETE FROM comments WHERE revelid IN (SELECT id FROM revels WHERE userid = ' . $_GET['id'] . ');');
    // Eliminamos los follows del usuario
    $conexion->query('DELETE FROM follows WHERE userid = ' . $_GET['id'] . ' OR userfollowed = ' . $_GET['id'] . ';');
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

    <body>
        <div class="content">
            <h1>¿Estás seguro de que quieres eliminar tu cuenta?</h1>
            <form action="cancel.php?id=<?= $_GET['id'] ?>" method="post">
                <input type="checkbox" name="confirm" id="confirm" required>
                <label for="confirm">Confirmo que quiero eliminar mi cuenta</label>
                <input type="submit" value="Eliminar">
            </form>
        </div>
    </body>

    </html>
<?php endif; ?>