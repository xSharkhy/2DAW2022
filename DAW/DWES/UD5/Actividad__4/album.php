<?php
/*
    Conecta con la base de datos discografia con PDO, si atrapa una excepción,
    redirige a una página segura.
*/
const DB_DSN = 'mysql:host=localhost;dbname=discografia';
const DB_OPTIONS = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
try {
    $conexion = new PDO(DB_DSN, 'vetustamorla', '15151', DB_OPTIONS);
} catch (PDOException $e) {
    header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    exit;
}

// Comprueba si el código del album es válido
$consulta = $conexion->prepare('SELECT * FROM albumes WHERE codigo = ?;');
$consulta->execute(array($_GET['album']));

// Si no se ha recibido el código del album o no es válido, redirige a la página principal
if (!isset($_GET['album']) || $consulta->rowCount() == 0) {
    header('Location: redirect.html');
    exit;
}

// Realiza la consulta de los temas del album
$consulta = $conexion->prepare('SELECT * FROM canciones WHERE album = ? ORDER BY posicion;');
$consulta->execute(array($_GET['album']));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <table>
        <tr>
            <th>Posición</th>
            <th>Título</th>
            <th>Duración</th>
        </tr>
        <?php
        // Muestra los temas en forma de tabla
        foreach ($consulta as $fila) {
            $fila['duracion'] = floor($fila['duracion'] / 60) . ':' . str_pad($fila['duracion'] % 60, 2, '0', STR_PAD_LEFT);
            echo '<tr><td>' . $fila['posicion'] . '</td><td>' . $fila['titulo'] . '</td><td>' . $fila['duracion'] . '</td></tr>';
        }

        
        ?>
    </table>
</body>

</html>