<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';

if (isset($_SESSION['user']) || isset($_SESSION['admin'])) header('Location: index.php');

if (isset($_GET['registered'])) $success = 'Usuario registrado correctamente.';

if (isset($_POST['login'])) :
    $consulta = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = ?;');
    $consulta->execute([$_POST['user']]);
    if ($consulta->rowCount() > 0) :
        $resultado = $consulta->fetch();
        if (password_verify($_POST['password'], $resultado['contrasenya'])) :
            if ($_POST['remember'] == 'on') :
                $token = bin2hex(random_bytes(32));
                $consulta = $conexion->prepare('UPDATE usuarios SET token = ? WHERE usuario = ?;');
                $consulta->execute([$token, $_POST['user']]);
                setcookie('TOKEN', $token, time() + 60 * 60 * 24 * 30, $httponly = true);
            endif;
            if ($resultado['rol'] == 'admin') :
                $_SESSION['admin'] = $resultado['usuario'];
                header('Location: index.php');
            else :
                $_SESSION['user'] = $resultado['usuario'];
                header('Location: index.php');
            endif;
        else :
            $error = 'Contraseña incorrecta';
        endif;
    else :
        $error = 'Usuario no registrado';
    endif;
endif;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop LOG IN | Ismael</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require_once 'include/header.inc.php'; ?>
    <main class="main__container">
        <h1>Log In</h1>
        <form action="#" method="POST">
            <?= $error ?? '' ?>
            <?= $success ?? '' ?>
            <label for="user">Usuario o Email</label>
            <input type="text" name="user" id="user" required><br>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required><br>
            <div>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Recordar mis datos</label><br>
            </div><br>
            <input type="submit" name="login" value="Iniciar Sesión">
            <p>¿Aún no tienes cuenta? <a href="index.php" id="registerB">Regístrate</a></p>
        </form>
    </main>
</body>

</html>