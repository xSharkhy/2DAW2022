<?php
// Recibe el código de un grupo por GET y muestra los álbumes de ese grupo.

// Conecta con la base de datos discografia con PDO
const DB_DSN = 'mysql:host=localhost;dbname=discografia';
const DB_OPTIONS = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

// Conecta a la base de datos, si atrapa una excepción, redirige a una página segura
try {
    $conexion = new PDO(DB_DSN, 'vetustamorla', '15151', DB_OPTIONS);
} catch (PDOException $e) {
    header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    exit;
}

// Comprueba si el código del grupo es válido
$consulta = $conexion->prepare('SELECT * FROM grupos WHERE codigo = ?;');
$consulta->execute(array($_GET['codigo']));

// Si no se ha recibido el código del grupo o no es válido, redirige a la página principal
if (!isset($_GET['codigo']) || $consulta->rowCount() == 0) {
    header('Location: redirect.html');
    exit;
}

// Realiza la consulta de los álbumes del grupo
$consulta = $conexion->prepare('SELECT * FROM albumes WHERE grupo = ? ORDER BY anyo;');
$consulta->execute(array($_GET['codigo']));
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
        // Muestra los álbumes en forma de lista ordenada
        foreach ($consulta as $fila)
            echo '<li><a href="album.php?codigo=' . $fila['codigo'] . '">' . $fila['titulo'] . '</a></li>';
        ?>
    </ol>
</body>

</html>