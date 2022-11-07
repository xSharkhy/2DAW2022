<?php
// Conecta con la base de datos discografia con PDO
const DB_DSN = 'mysql:host=localhost;dbname=discografia';
const DB_OPTIONS = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

// Conecta a la base de datos y realiza la consulta, si atrapa una excepción, redirige a una página segura
try {
    $conexion = new PDO(DB_DSN, 'vetustamorla', '15151', DB_OPTIONS);
    $resultado = $conexion->query('SELECT * FROM grupos ORDER BY nombre;');
} catch (PDOException $e) {
    header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
</head>
<body>
    <ol>
        <?php
        // Muestra los grupos en forma de lista ordenada
        foreach ($resultado as $fila)
            echo '<li><a href="grupos.php?codigo=' . $fila['codigo'] . '">' . $fila['nombre'] . '</a></li>';
        ?>
    </ol>
</body>
</html>