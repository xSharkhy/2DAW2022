<?php
require_once 'include/dbconnection.inc.php';
ini_set('session.name', 'SSID');
ini_set('session.cookie_httponly', 1);
session_start();

if (isset($_COOKIE['TOKEN']) && !isset($_SESSION['user'])) :
    $consulta = $conexion->prepare('SELECT * FROM usuarios WHERE token = ?;');
    $consulta->execute([$_COOKIE['TOKEN']]);
    if ($consulta->rowCount() > 0) :
        $resultado = $consulta->fetch();
        if($resultado['rol'] == 'admin') :
            $_SESSION['admin'] = $resultado['usuario'];
            header('Location: index.php');
        else :
            $_SESSION['user'] = $resultado['usuario'];
            header('Location: admin.php');
        endif;
    endif;
endif;