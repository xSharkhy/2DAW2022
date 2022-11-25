<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Si el usuario no está autenticado, o el usuario no ha enviado la petición POST, redirigir a index.php
if (!isset($_SESSION['user']) || !isset($_POST['revelid'])) header('Location: index.php');

// Si el revel no existe, redirigir a index.php
$consulta = $conexion->prepare('SELECT * FROM revels WHERE id = ?;');
$consulta->execute(array($_POST['revelid']));
if ($consulta->rowCount() == 0) header('Location: index.php');

// Si el comentario está vacío, o es mayor a 254 caracteres salta error
if (empty($_POST['comment']) || strlen($_POST['comment']) > 254) $error = 'El comentario no puede estar vacío o tener más de 254 caracteres';

if (!isset($error)) :
    // Insertar comentario en la base de datos
    $consulta = $conexion->prepare('INSERT INTO comments (userid, revelid, texto) VALUES (?, ?, ?);');
    $consulta->execute(array($_SESSION['id'], $_POST['revelid'], $_POST['comment']));
    header('Location: revel.php?id=' . $_POST['revelid']);
else :
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>COMMENT Revels | Ismael</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" href="img/ICONO-NEGATIVO.svg" type="image/x-icon">
    </head>

    <body>
        <main>
            <?php
            require_once 'include/header.inc.php';
            ?>
            <div class="content">
                <div class="revel__page">
                    <img src="img/filler.png" alt="Filler">
                    <div class="revel__page__content">
                        <h3>Error:</h3>
                        <p><?= $error ?></p>
                        <a href="index.php" class="volver">Volver</a>
                    </div>
                </div>
            </div>
        </main>
    </body>

    </html>
<?php
endif;
?>