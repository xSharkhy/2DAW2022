<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Comprobamos que el usuario está logueado
if (!isset($_SESSION['user'])) header('Location: index.php');

// Comprobamos que se ha enviado el formulario
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
        $consulta = $conexion->query('SELECT * FROM users WHERE id != ' . $_SESSION['id'] . ';');
        while ($usuario = $consulta->fetch()) :
            if ($usuario['email'] == $_POST['email']) $error['email'] = 'El email ya está registrado';
            if ($usuario['usuario'] == $_POST['user']) $error['user'] = 'El nombre de usuario ya está registrado';
        endwhile;
    endif;

    if (!isset($error)) :
        $consulta = $conexion->prepare('UPDATE users SET email = ?, usuario = ?, contrasenya = ? WHERE id = ?;');
        $consulta->execute([$_POST['email'], $_POST['user'], password_hash($_POST['pass'], PASSWORD_DEFAULT), $_SESSION['id']]);
        $_SESSION['user'] = $_POST['user'];
        header('Location: account.php');
    endif;
else :
    $consulta = $conexion->prepare('SELECT * FROM users WHERE id = ?;');
    $consulta->execute([$_SESSION['id']]);
    $usuario = $consulta->fetch();
    $_POST['email'] = $usuario['email'];
    $_POST['user'] = $usuario['usuario'];
endif;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCOUNT Revels | Ismael</title>
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
    <h1>ACCOUNT Revels | Ismael</h1>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo $_POST['email']; ?>">
        <?php if (isset($error['email'])) echo $error['email']; ?>
        <label for="user">Usuario</label>
        <input type="text" name="user" id="user" value="<?php echo $_POST['user']; ?>">
        <?php if (isset($error['user'])) echo $error['user']; ?>
        <label for="pass">Contraseña</label>
        <input type="password" name="pass" id="pass">
        <?php if (isset($error['pass'])) echo $error['pass']; ?>
        <label for="repass">Repite la contraseña</label>
        <input type="password" name="repass" id="repass">
        <?php if (isset($error)) echo 'Las contraseñas no coinciden'; ?>
        <input type="submit" value="Actualizar">
    </form>
    <div class="eliminaCuenta">
        <h1>Eliminar cuenta de REVELS</h1>
        <p>Si eliminas tu cuenta, no podrás recuperarla ni los datos que hayas guardado en ella.</p>
        <a href="cancel.php?id=<?= $_SESSION['id'] ?>">Eliminar cuenta</a>
    </div>
    <div class="verRevels">
        <h1>Ver tus REVELS</h1>
        <a href="list.php">Ver tus REVELS</a>
    </div>
</body>

</html>