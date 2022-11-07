<?php
// Declaramos las constantes de conexión
const DB_DSN = 'mysql:host=localhost;dbname=dungeonsanddragons';
const DB_OPTIONS = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

// Conecta a la base de datos y realiza la consulta, si atrapa una excepción, redirige a una página segura
try {
    $conexion = new PDO(DB_DSN, 'dad', 'd20', DB_OPTIONS);
    $resultado = $conexion->query('SELECT * FROM jugadores;');
} catch (PDOException $e) {
    header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 1rem;
        }

        a {
            text-decoration: none;
            color: black;
        }

        button {
            float: right;
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f1f1f1;
            border: 1px solid black;
            border-radius: 0.5rem;
            box-shadow: 0 0 0.5rem black;
        }

        button:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>Nick</th>
            <th>Mail</th>
            <th>País</th>
            <th>Fecha de nacimiento</th>
            <th>Monedas</th>
        </tr>
        <?php
        // Muestra los datos de los jugadores en una tabla
        while ($fila = $resultado->fetch()) {
            echo '<tr>';
            echo '<td>' . $fila['nick'] . '</td>';
            echo '<td>' . $fila['mail'] . '</td>';
            echo '<td>' . $fila['pais'] . '</td>';
            echo '<td>' . $fila['fechanacimiento'] . '</td>';
            echo '<td>' . $fila['monedas'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>

    <a href="crearJugadorIsmael.php" id="boton"><button>Crea un jugador!</button></a>
</body>

</html>