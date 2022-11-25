<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Si el usuario no está autenticado, o el usuario no ha enviado la petición GET, redirigir a index.php
if (!isset($_SESSION['user']) || !isset($_GET['id'])) header('Location: index.php');

// Si el revel no existe, redirigir a index.php
$consulta = $conexion->prepare('SELECT * FROM revels WHERE id = ?;');
$consulta->execute(array($_GET['id']));
if ($consulta->rowCount() == 0) header('Location: index.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REVEL <?= $_GET['id'] ?> | Ismael</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/ICONO-NEGATIVO.svg" type="image/x-icon">
</head>

<body>
    <main>
        <?php
        require_once 'include/header.inc.php';
        $revel = $consulta->fetch();
        $consulta = $conexion->prepare('SELECT * FROM users WHERE id = ?;');
        $consulta->execute(array($revel['userid']));
        $usuario = $consulta->fetch();
        ?>
        <div class="content">
            <div class="revel__page">
                <img src="img/filler.png" alt="Filler">
                <div class="revel__page__content">
                    <span class="user__revel"><?= $usuario['usuario'] ?></span> - <span class="timestamp"><?= $revel['fecha'] ?></span>
                    <p><?= $revel['texto'] ?></p>
                    <h3>Comentarios:</h3>
                    <?php
                    $consulta = $conexion->prepare('SELECT * FROM comments WHERE revelid = ?;');
                    $consulta->execute(array($_GET['id']));
                    if ($consulta->rowCount() == 0) :
                        echo '<p class="noRevels">No hay comentarios que mostrar</p>';
                    else :
                        while ($comentario = $consulta->fetch()) :
                            $consulta2 = $conexion->prepare('SELECT * FROM users WHERE id = ?;');
                            $consulta2->execute(array($comentario['userid']));
                            $usuario = $consulta2->fetch();
                    ?>
                            <div class="comment">
                                <span class="user__revel"><?= $usuario['usuario'] ?></span> - <span class="timestamp"><?= $comentario['fecha'] ?></span>
                                <p><?= $comentario['texto'] ?></p>
                            </div>
                    <?php
                        endwhile;
                    endif;
                    ?>
                    <form action="comment.php" method="post">
                        <input type="hidden" name="revelid" value="<?= $_GET['id'] ?>">
                        <input name="comment" id="comment" class="comment__input" placeholder="Escribe un comentario..."></input>
                        <input type="submit" class="comment__button" value="Comentar">
                    </form>
                </div>
            </div>
        </div>
        </header>
    </main>
</body>

</html>