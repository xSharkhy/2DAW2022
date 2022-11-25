<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Si el usuario ya está logueado, lo redirigimos a la página de inicio
if (isset($_SESSION['user'])) header('Location: index.php');

// Si el usuario se acaba de registrar, mostramos un mensaje de éxito
if (isset($_GET['registered'])) $success = '<h3>Usuario registrado correctamente.</h3>';

/*
    Si el usuario ha enviado el formulario de login, comprobamos que:
    - El usuario existe en la base de datos
    - La contraseña es correcta
*/
if (isset($_POST['login'])) :
    $consulta = $conexion->prepare('SELECT * FROM users WHERE usuario LIKE ? OR email LIKE ?;');
    $consulta->execute(array($_POST['user'], $_POST['user']));
    if ($consulta->rowCount() > 0) :
        $resultado = $consulta->fetch();
        if (password_verify($_POST['pass'], $resultado['contrasenya'])) :
            $_SESSION['user'] = $resultado['usuario'];
            $_SESSION['id'] = $resultado['id'];
            header('Location: index.php');
        else :
            $error['pass'] = 'Contraseña incorrecta';
        endif;
    else :
        $error['user'] = 'Usuario no registrado';
    endif;
endif;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REVELS LOG IN | Ismael</title>
    <link rel="stylesheet" href="css/foreignStyle.css">
</head>

<body>
    <main class="login__main">
        <div class="login">
            <div class="registro">
                <div class="bulto"></div>
                <form action="#" class="register__form" method="post">
                    <fieldset>
                        <?= $success ?? '' ?>
                        <legend><span class="join__span">Inicia sesión en Revels.</span></legend>
                        <label for="user">Usuario</label><br>
                        <input type="text" name="user" id="user" class="input__box" placeholder="Usuario" required>
                        <?= $error['user'] ?? '' ?><br>
                        <label for="pass">Contraseña</label><br>
                        <input type="password" name="pass" id="pass" class="input__box" placeholder="Contraseña" required>
                        <?= $error['pass'] ?? '' ?><br>
                        <input type="submit" name="login" class="register__button" value="Iniciar sesión">
                    </fieldset>
                </form>
                <div class="register__link">
                    <span>¿No tienes una cuenta? <a href="index.php">Regístrate</a></span>
                </div>
            </div>
        </div>
        <div class="descripcion">
            <div>
                <p>Sigue tus intereses.</p>
                <p>Escucha lo que la gente tiene que decir.</p>
                <p>Únete a la conversación.</p>
            </div>
        </div>
    </main>
</body>

</html>