<?php
require_once 'include/dbconnection.inc.php';
session_start();

/*
    CASO 1: El usuario no está logueado.
    - Se muestra un formulario de registro y login.
    - El formulario de login mandará los datos a login.php.
    CASO 2: El usuario está logueado.
    - Se hace una consulta a la base de datos para obtener todos los revels.
    - Se muestran los revels.

    Si se ha enviado el formulario, comprobamos que:
        (1) Ningún campo esté vacío
        (2) Los campos cumplan sus RegExp
        (3) Las contraseñas coincidan
        (4) El usuario no exista en la base de datos
        (5) El email no exista en la base de datos
    Si todo es correcto, registramos al usuario en la base de datos
*/
if (!empty($_POST)) :
    foreach ($_POST as $key => $value) :
        $_POST[$key] = trim($value);
        if (empty($_POST[$key])) $error = true;
    endforeach;

    if (!isset($error)) :
        preg_match('/^.+@.+\..+$/', $_POST['email']) ? true : $error['email'] = 'El email no es válido' . '<br>';
        preg_match('/^[0-9a-zA-Z\_]{3,20}$/', $_POST['user']) ? true : $error['user'] = 'El nombre de usuario debe tener entre 3 y 20 caracteres' . '<br>';
        preg_match('/^[0-9a-zA-ZÀ-ÿñÑçÇ\'\-\s]{8,255}$/', $_POST['pass']) ? true : $error['pass'] = 'La contraseña debe contener, al menos, 8 caracteres.';
    endif;

    if (!isset($error)) :
        $_POST['pass'] == $_POST['repass'] ? true : $error = 1;
    endif;

    if (!isset($error)) :
        $consulta = $conexion->query('SELECT * FROM users;');
        while ($usuario = $consulta->fetch()) :
            if ($usuario['email'] == $_POST['email']) $error['email'] = 'El email ya está registrado';
            if ($usuario['usuario'] == $_POST['user']) $error['user'] = 'El nombre de usuario ya está registrado';
        endwhile;
    endif;

    if (!isset($error)) :
        $consulta = $conexion->prepare('INSERT INTO users (usuario, contrasenya, email) VALUES (?, ?, ?);');
        $consulta->execute([$_POST['user'], password_hash($_POST['pass'], PASSWORD_DEFAULT), $_POST['email']]);
        header('Location: login.php?registered');
    endif;
endif;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revels INICIO | Ismael</title>
    <?php
    if (isset($_SESSION['user'])) echo '<link rel="stylesheet" href="css/style.css">';
    else echo '<link rel="stylesheet" href="css/foreignStyle.css">';
    ?>
    <link rel="shortcut icon" href="img/ICONO-NEGATIVO.svg" type="image/x-icon">
</head>

<body>
    <main>
        <?php
        if (isset($_SESSION['user'])) :
            require_once 'include/header.inc.php';
        ?>

            <div class="content">
                <div class="revels">
                    <?php
                    $consulta = $conexion->prepare("SELECT * FROM revels WHERE userid = ? OR userid IN (SELECT userfollowed FROM follows WHERE userid = ?) ORDER BY fecha DESC");
                    $consulta->execute([$_SESSION['id'], $_SESSION['id']]);
                    if ($consulta->rowCount() == 0) :
                        echo '<p class="noRevels">No hay revels que mostrar</p>';
                    else :
                        while ($revel = $consulta->fetch()) :
                            $consulta2 = $conexion->prepare("SELECT * FROM users WHERE id = ?");
                            $consulta2->execute([$revel['userid']]);
                            $usuario = $consulta2->fetch();
                    ?>
                            <a href="revel.php?id=<?= $revel['id'] ?>" class="revel">
                                <span class="user__revel"><?= $usuario['usuario'] ?></span> - <span class="timestamp"><?= $revel['fecha'] ?></span>
                                <img src="img/filler.png" alt="Filler Image" class="floating__image">
                                <p><br><?= $revel['texto'] ?></p>
                            </a>
                    <?php
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
                </div>
        <?php
        else : ?>
            <div class="login">
                <form action="login.php" class="login__form" method="post">
                    <input type="text" name="user" id="user" class="input__box" placeholder="Usuario" required>
                    <input type="password" name="pass" id="pass" class="input__box" placeholder="Contraseña" required>
                    <input type="submit" name="login" class="login__button" value="Iniciar sesión">
                </form>
                <div class="registro">
                    <img src="img/ICONO.svg" class="login__logo" alt="logo">
                    <span class="lema">Ve lo que está pasando en el mundo ahora mismo.</span>
                    <form action="#" class="register__form" method="post">
                        <fieldset>
                            <legend><span class="join__span">Únete hoy a Revels.</span></legend>
                            <label for="user">Usuario</label><br>
                            <input type="text" name="user" id="user" class="input__box" placeholder="Usuario" required>
                            <?= $error['user'] ?? '' ?><br>
                            <label for="email">Email</label><br>
                            <input type="text" name="email" id="email" class="input__box" placeholder="Email" required>
                            <?= $error['email'] ?? '' ?><br>
                            <label for="pass">Contraseña</label><br>
                            <input type="password" name="pass" id="pass" class="input__box" placeholder="Contraseña" required>
                            <?= $error['pass'] ?? '' ?><br>
                            <label for="pass">Repetir Contraseña</label><br>
                            <input type="password" name="repass" id="repass" class="input__box" placeholder="Repetir Contraseña" required>
                            <?= $error['repass'] ?? '' ?><br>
                            <input type="submit" name="register" class="register__button" value="Registrarme">
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="descripcion">
                <div>
                    <p>Sigue tus intereses.</p>
                    <p>Escucha lo que la gente tiene que decir.</p>
                    <p>Únete a la conversación.</p>
                </div>
            </div>
        <?php endif;
        $conexion = null
        ?>
    </main>
</body>

</html>