<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Comprobamos que el usuario está logueado
if (!isset($_SESSION['user'])) header('Location: index.php');

// Comprobamos que se ha enviado el formulario
if (isset($_POST)) :
    if (isset($_POST['userfollowed'])) :
        // Comprobamos que si el usuario ya sigue a ese usuario
        $follow = $conexion->query('SELECT * FROM follows WHERE userid = ' . $_SESSION['id'] . ' AND userfollowed = ' . $_POST['userfollowed'] . ';');
        if ($follow->rowCount() > 0) :
            // Si ya lo sigue, lo dejamos de seguir
            $conexion->query('DELETE FROM follows WHERE userid = ' . $_SESSION['id'] . ' AND userfollowed = ' . $_POST['userfollowed'] . ';');
        else :
            // Si no lo sigue, lo seguimos
            $conexion->query('INSERT INTO follows (userid, userfollowed) VALUES (' . $_SESSION['id'] . ', ' . $_POST['userfollowed'] . ');');
        endif;
        header('Location: index.php');
    else :
        if (isset($_POST['search']) && !empty($_POST['search'])) :
            // Buscamos los usuarios que coincidan con la búsqueda
            $users = $conexion->query('SELECT * FROM users WHERE usuario LIKE "%' . $_POST['search'] . '%" AND id != ' . $_SESSION['id'] . ';');
        endif;
    endif;
endif;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESULTADOS Revels | Ismael</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/ICONO-NEGATIVO.svg" type="image/x-icon">
</head>

<body>
    <?php require_once 'include/header.inc.php'; ?>
    <div class="content">
        <?php if (isset($users)) : ?>
            <?php if ($users->rowCount() > 0) : ?>
                <?php while ($user = $users->fetch()) : ?>
                    <div class="user">
                        <a href="profile.php?id=<?= $user['id'] ?>"><?= $user['usuario'] ?></a>
                        <form action="results.php" method="post">
                            <input type="hidden" name="userfollowed" value="<?= $user['id'] ?>">
                            <?php
                            $follow = $conexion->query('SELECT * FROM follows WHERE userid = ' . $_SESSION['id'] . ' AND userfollowed = ' . $user['id'] . ';');
                            if ($follow->rowCount() > 0) :
                            ?>
                                <input type="submit" value="Dejar de seguir">
                            <?php else : ?>
                                <input type="submit" value="Seguir">
                            <?php endif;?>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No se han encontrado resultados</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>

</html>