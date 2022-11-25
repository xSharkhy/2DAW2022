<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Comprobamos que el usuario está logueado
if (!isset($_SESSION['user'])) header('Location: index.php');

// Comprobamos que se ha enviado el formulario
if (!empty($_POST)) :
    foreach ($_POST as $key => $value) {
        $value = trim($value);
        if (empty($value)) {
            $error = 'No se ha podido enviar el formulario';
            break;
        }
    }
    if (!isset($error)) :
        $insert = $conexion->prepare('INSERT INTO revels (userid, texto) VALUES (?, ?);');
        $insert->execute([$_SESSION['id'], $_POST['texto']]);
        header('Location: revel.php?id=' . $conexion->lastInsertId());
    endif;
endif;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUEVO Revels | Ismael</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/ICONO-NEGATIVO.svg" type="image/x-icon">
</head>

<body>
    <?php require_once 'include/header.inc.php'; ?>
    <div class="content">
        <?php if (isset($error)) : ?>
            <div class="error">
                <p><?= $error ?></p>
            </div>
        <?php endif; ?>
        <form action="#" method="post">
            <input type="text" name="texto" placeholder="¿Qué quieres revelar?">
            <input type="submit" value="Revelar">
        </form>
    </div>
</body>

</html>