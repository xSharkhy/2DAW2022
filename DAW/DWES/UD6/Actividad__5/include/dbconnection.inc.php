<?php
/*
    Include de la conexión a la base de datos para poder hacer consultas
    a la base de datos desde cualquier página.

    Las constantes de conexión a la base de datos definen el nombre de la base de datos,
    el host y un array de opciones para la conexión mediante PDO.
*/
const DB_DSN = 'mysql:host=localhost;dbname=tiendamercha';
const DB_OPTIONS = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
try {
    $conexion = new PDO(DB_DSN, 'Lumos', 'Nox', DB_OPTIONS);
} catch (PDOException $e) {
    $conexion = null;
    header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    exit;
}
