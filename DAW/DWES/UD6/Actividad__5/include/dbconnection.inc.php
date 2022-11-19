<?php
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
