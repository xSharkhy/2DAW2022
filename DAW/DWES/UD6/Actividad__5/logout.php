<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';

// Elimina la sesión y la cookie de autologin.
setcookie('TOKEN', '', time() - 1);

// Actualiza la base de datos para eliminar el token de autologin.
if (isset($_SESSION['user']))
    $conexion->query('UPDATE usuarios SET token = 0 WHERE usuario = "' . $_SESSION['user'] . '";');
elseif (isset($_SESSION['admin']))
    $conexion->query('UPDATE usuarios SET token = 0 WHERE usuario = "' . $_SESSION['admin'] . '";');

session_destroy();
header('Location: index.php');