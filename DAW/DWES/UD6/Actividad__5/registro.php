<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';

// Si el usuario está logueado, lo redirigimos a la página de inicio
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) header('Location: index.php');

/*
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
        preg_match('/^.+@.+\..+$/', $_POST['mail']) ? true : $error['mail'] = 'El email no es válido' . '<br>';
        preg_match('/^[0-9a-zA-Z\_]{3,20}$/', $_POST['user']) ? true : $error['user'] = 'El nombre de usuario debe tener entre 3 y 20 caracteres' . '<br>';
        preg_match('/^[0-9a-zA-ZÀ-ÿñÑçÇ\'\-\s]{8,255}$/', $_POST['password']) ? true : $error['password'] = 'La contraseña debe contener, al menos, 8 caracteres.';
    endif;

    if (!isset($error)) :
        $_POST['password'] == $_POST['repassword'] ? true : $error = 1;
    endif;

    if (!isset($error)) :
        $consulta = $conexion->query('SELECT * FROM usuarios;');
        while ($usuario = $consulta->fetch()) :
            if ($usuario['email'] == $_POST['mail']) $error['mail'] = 'El email ya está registrado';
            if ($usuario['usuario'] == $_POST['user']) $error['user'] = 'El nombre de usuario ya está registrado';
        endwhile;
    endif;

    if (!isset($error)) :
        $consulta = $conexion->prepare('INSERT INTO usuarios (usuario, contrasenya, email, token) VALUES (?, ?, ?, ?);');
        $consulta->execute([$_POST['user'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['mail'], 0]);
        header('Location: login.php?registered');
    endif;
endif;

$conexion = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop REGISTRO | Ismael</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once 'include/header.inc.php'; ?>
    <main class="main__container">
        <h1>Registro</h1>
        <form action="#" method="POST">
            <?= isset($error) ? (is_bool($error) ? 'Hay campos vacíos' : (is_numeric($error) ? 'Las contraseñas no coinciden' : '')) : '' ?>
            <label for="mail">Email</label>
            <input type="email" name="mail" id="mail" required><?= $error['mail'] ?? '' ?><br>
            <label for="user">Usuario</label>
            <input type="text" name="user" id="user" required><?= $error['user'] ?? '' ?><br>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required><?= $error['password'] ?? '' ?><br>
            <label for="repassword">Repite la contraseña</label>
            <input type="password" name="repassword" id="repassword" required><br>
            <input type="submit" name="register" value="Registrarse">
            <p>¿Ya tienes cuenta? <a href="login.php" id="loginB">Inicia Sesión</a></p>
        </form>
    </main>
</body>
</html>