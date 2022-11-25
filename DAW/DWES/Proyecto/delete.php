<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Si el usuario no está autenticado, o el usuario no ha enviado la petición GET, redirigir a index.php
if (!isset($_SESSION['user']) || !isset($_GET['id'])) header('Location: index.php');

// Si el revel no existe, redirigir a index.php
$consulta = $conexion->prepare('SELECT * FROM revels WHERE id = ?;');
$consulta->execute(array($_GET['id']));
if ($consulta->rowCount() == 0) header('Location: index.php');

// Eliminar revel de la base de datos
$consulta = $conexion->prepare('DELETE FROM revels WHERE id = ?;');
$consulta->execute(array($_GET['id']));
header('Location: list.php');
?>