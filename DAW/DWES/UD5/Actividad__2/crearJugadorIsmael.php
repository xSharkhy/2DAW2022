<?php
// Declaramos las constantes de conexión
const DB_DSN = 'mysql:host=localhost;dbname=dungeonsanddragons';
const DB_OPTIONS = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

if (!empty($_POST)) { // El script solo se ejecutará si se ha enviado el formulario

    // Recorremos el array $_POST. Eliminamos espacios en blanco al principio y al final
    // Si el campo está vacío, se marca como error
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
        if (empty($_POST[$key])) $error[$key] = true;
    }

    // Si la variable $error está inicializada, muestra un error y acaba la ejecución
    if (isset($error)) echo '<div class="error">Hay campos vacíos en el formulario</div>';

    // Si no hay registro de error, valida todo el formulario con expresiones regulares
    // Si el contenido del formulario no concuerda con la regexp, se imprimirá un error bajo el campo.
    else {
        preg_match('/^[a-zA-Z]{4,16}$/', $_POST['nick']) ? true : $error['nick'] = 'El nombre de usuario debe tener entre 4 y 16 caracteres' . '<br>';
        preg_match('/^.+@.+\..+$/', $_POST['mail']) ? true : $error['mail'] = 'El email no es válido' . '<br>';
        preg_match('/^[a-zA-ZñÑ\'\-]{3,}$/', $_POST['pais']) ? true : $error['pais'] = 'El nombre debe tener almenos 3 caracteres' . '<br>';
        preg_match('/^(0[1-9]|[12][0-9]|3[01])(\-|\.|\/)(0[1-9]|1[012])(\-|\.|\/)(19[0-9]{2}|20[01][0-9]|202[12])$/', $_POST['fecha']) ? true : $error['fecha'] = 'La fecha debe tener el formato DD/MM/YYYY' . '<br>';
        preg_match('/^[0-9]{1,}$/', $_POST['monedas']) ? true : $error['monedas'] = 'Las monedas deben ser un número' . '<br>';

        // Si la variable $error no está inicializada, sigue la ejecución
        if (!isset($error)) {

            // Corregimos la fecha para que se pueda insertar en la base de datos
            $separador = preg_match('/\-/', $_POST['fecha']) ? '-' : (preg_match('/\./', $_POST['fecha']) ? '.' : '/');
            $fecha = explode($separador, $_POST['fecha']);
            $_POST['fecha'] = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];

            // Conecta a la base de datos
            try {
                $conexion = new PDO(DB_DSN, 'dad', 'd20', DB_OPTIONS);
            } catch (PDOException $e) {
                header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
            }

            // Comprueba si el nick o el mail ya existe en la base de datos
            // Si existe, se marca como error, se muestra un mensaje y se acaba la ejecución

            // Prepara la consulta
            $sentencia = $conexion->prepare('SELECT * FROM jugadores WHERE nick = :nick OR mail = :mail;');

            // Ejecuta la consulta
            $sentencia->execute(array(':nick' => $_POST['nick'], ':mail' => $_POST['mail']));
            if ($sentencia->rowCount() > 0) {
                echo '<div class="error">El nick o el mail ya existe</div>';
            } else {
                // Prepara la consulta insert
                $consulta = $conexion->prepare('INSERT INTO jugadores (nick, mail, pais, fechanacimiento, monedas) VALUES (:nick, :mail, :pais, :fecha, :monedas);');

                // Ejecuta la consulta
                $consulta->execute(array(
                    ':nick' => $_POST['nick'],
                    ':mail' => $_POST['mail'],
                    ':pais' => $_POST['pais'],
                    ':fecha' => $_POST['fecha'],
                    ':monedas' => $_POST['monedas']
                ));

                // Redirige a la página de jugadores
                header('Location: jugadoresIsmael.php');
            }
        }
    }
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
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        * {
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        .flex__container {
            display: flex;
            flex-direction: column;
        }

        .flex__item {
            display: flex;
            justify-content: flex-end;
            padding: .5em;
        }

        .flex__item>label {
            padding: .5em 1em .5em 0;
            flex: 1;
        }

        .flex__item>input {
            flex: 5;
        }

        .flex__item>input {
            padding: .5em;
        }

        .button {
            background: whitesmoke;
            color: black;
            border: 1px solid black;
            box-shadow: .5em .5em 0 black;
            cursor: pointer;
            margin: 1em 0;
            padding: 1em;
        }

        .button:hover {
            margin: 1.5em 0.5em;
            box-shadow: none;
        }

        .error {
            display: inline-block;
            color: red;
            margin: 0;
            padding: 0 .5em 0 0;
        }
    </style>
</head>

<body>
    <form action="#" method="POST" class="flex__container">
        <div class="flex__item">
            <label for="usuario">Usuario</label>
            <input type="text" name="nick" id="nick" placeholder="Nick" <?= isset($error) ? (isset($_POST['nick']) ? 'value="' . $_POST['nick'] . '"' : '') : '' ?>><br>
        </div>
        <div class="error flex__item">
            <?= isset($error['nick']) ? (is_bool($error['nick']) ? '' : $error['nick']) : '' ?>
        </div>
        <div class="flex__item">
            <label for="mail">Email</label>
            <input type="text" name="mail" id="mail" placeholder="Email" <?= isset($error) ? (isset($_POST['mail']) ? 'value="' . $_POST['mail'] . '"' : '') : '' ?>><br>
        </div>
        <div class="error flex__item">
            <?= isset($error['mail']) ? (is_bool($error['mail']) ? '' : $error['mail']) : '' ?>
        </div>
        <div class="flex__item">
            <label for="pais">País</label>
            <input type="text" name="pais" id="pais" placeholder="País" <?= isset($error) ? (isset($_POST['pais']) ? 'value="' . $_POST['pais'] . '"' : '') : '' ?>><br>
        </div>
        <div class="error flex__item">
            <?= isset($error['pais']) ? (is_bool($error['pais']) ? '' : $error['pais']) : '' ?>
        </div>
        <div class="flex__item">
            <label for="fecha">Fecha</label>
            <input type="text" name="fecha" id="fecha" placeholder="Fecha" <?= isset($error) ? (isset($_POST['fecha']) ? 'value="' . $_POST['fecha'] . '"' : '') : '' ?>><br>
        </div>
        <div class="error flex__item">
            <?= isset($error['fecha']) ? (is_bool($error['fecha']) ? '' : $error['fecha']) : '' ?>
        </div>
        <div class="flex__item">
            <label for="monedas">Monedas</label>
            <input type="text" name="monedas" id="monedas" placeholder="Monedas" <?= isset($error) ? (isset($_POST['monedas']) ? 'value="' . $_POST['monedas'] . '"' : '') : '' ?>><br>
        </div>
        <div class="error flex__item">
            <?= isset($error['monedas']) ? (is_bool($error['monedas']) ? '' : $error['monedas']) : '' ?>
        </div>
        <input class="button" type="submit" value="Enviar">
    </form>
</body>

</html>