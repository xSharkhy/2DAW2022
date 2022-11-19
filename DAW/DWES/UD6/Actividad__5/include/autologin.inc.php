<?php
/*
    Include de la conexión a la base de datos para poder loguear al usuario automáticamente
    si tiene la cookie de autologin activa.

    Desde aquí se controla la sesión de todos los usuarios que acceden a la web.
*/
require_once 'include/dbconnection.inc.php';
ini_set('session.name', 'SSID');
ini_set('session.cookie_httponly', 1);
session_start();

/* 
    Si el usuario no está logueado y tiene la cookie de autologin activa, se loguea automáticamente
    mediante una consulta a la base de datos.
*/
if (isset($_COOKIE['TOKEN']) && (!isset($_SESSION['user']) || !isset($_SESSION['admin']))) :
    $consulta = $conexion->prepare('SELECT * FROM usuarios WHERE token = ?;');
    $consulta->execute([$_COOKIE['TOKEN']]);
    if ($consulta->rowCount() > 0) :
        $resultado = $consulta->fetch();
        if ($resultado['rol'] == 'admin') $_SESSION['admin'] = $resultado['usuario'];
        else $_SESSION['user'] = $resultado['usuario'];
    endif;
endif;
