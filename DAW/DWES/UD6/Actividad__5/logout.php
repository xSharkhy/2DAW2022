<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';
setcookie('TOKEN', '', time() - 1);

if (isset($_SESSION['user']))
    $conexion->query('UPDATE usuarios SET token = NULL WHERE usuario = "' . $_SESSION['user'] . '";');
elseif (isset($_SESSION['admin']))
    $conexion->query('UPDATE usuarios SET token = NULL WHERE usuario = "' . $_SESSION['admin'] . '";');

session_destroy();
header('Location: index.php');