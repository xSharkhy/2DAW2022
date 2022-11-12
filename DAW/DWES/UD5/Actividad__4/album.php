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

// Consulta para el botón de 'Volver'
$consulta = $conexion->prepare('SELECT grupo FROM albumes WHERE codigo = ?;');
$consulta->execute(array($_GET['album']));
$grupo = $consulta->fetch();

/*
    Comprueba si ha recibido el código del álbum por GET y comprueba que es un
    número entero positivo. Si es correcto, validará mediante una consulta a la
    base de datos si existe el álbum. Si no existe, redirige a la página de error.
*/
if (isset($_GET['album']) && ctype_digit($_GET['album'])) {
    $consulta = $conexion->prepare('SELECT * FROM albumes WHERE codigo = ?');
    $consulta->execute(array($_GET['album']));
    if ($consulta->rowCount() == 0) {
        header('Location: error.php');
        exit;
    }
} else {
    header('Location: error.php');
    exit;
}

// Realiza la consulta de los temas del album
$resultado = $conexion->prepare('SELECT * FROM canciones WHERE album = ? ORDER BY titulo;');
$resultado->execute(array($_GET['album']));

if (!empty($_POST)) {
    // Si llegan datos por post,validamos el formulario
    foreach ($_POST as $key => $value) $_POST[$key] = trim($value);
    if (isset($_POST['titulo'])) {
        if (empty($_POST['titulo'])) {
            $error['titulo'] = 'El titulo no puede estar vacío.';
        } else {
            preg_match('/^[0-9a-zA-ZÀ-ÿñÑçÇ\'\-\s]{1,50}$/', $_POST['titulo']) ? true : $error['titulo'] = 'El título debe tener máximo 50 caracteres';
        }
    }
    // Comprobamos los datos de tiempo y los convertimos a segundos
    if (isset($_POST['minutos']) && isset($_POST['segundos'])) {
        if (empty($_POST['minutos']) && empty($_POST['segundos'])) {
            $error['duracion'] = 'La duración no puede estar vacía.';
        } else {
            if (empty($_POST['minutos'])) $_POST['minutos'] = 0;
            if (empty($_POST['segundos'])) $_POST['segundos'] = 0;
            if (!is_numeric($_POST['minutos']) && $_POST['minutos'] < 0 || !is_numeric($_POST['segundos']) && $_POST['segundos'] < 0)
                $error['duracion'] = 'La duración debe ser un número entero positivo.';
            else {
                $duracion = $_POST['minutos'] * 60 + $_POST['segundos'];
                if ($duracion > 3600) $error['duracion'] = 'La duración no puede ser mayor de 1 hora.';
            }
        }

        if (!isset($error)) {
            if (isset($_POST['codigo'])) { // Si existe el código, actualizamos el tema
                $consulta = $conexion->prepare('UPDATE canciones SET titulo = ?, duracion = ? WHERE codigo = ?');
                $consulta->execute(array($_POST['titulo'], $duracion, $_POST['codigo']));
                header('Location: album.php?album=' . $_GET['album']);
            } else { // Si no existe el código, insertamos el tema
                $consulta = $conexion->prepare('INSERT INTO canciones (titulo, duracion, album) VALUES (?, ?, ?)');
                $consulta->execute(array($_POST['titulo'], $duracion, $_GET['album']));
                header('Location: album.php?album=' . $_GET['album']);
            }
        }
    }
}
/*
    Si llega el código del tema por GET junto con una acción, comprueba la acción.
        BORRAR:     Borra el tema de la base de datos.
        EDITAR:     Realiza una consulta para obtener los datos del tema y los mandará
                    al formulario por POST.
        CONFIRMAR:  Muestra un mensaje de confirmación de borrado y mandará el código 
                    y el título del tema por POST.
*/ elseif (isset($_GET['accion']) && isset($_GET['codigo'])) {
    switch ($_GET['accion']) {
        case 'borrar':
            $consulta = $conexion->prepare('DELETE FROM canciones WHERE codigo = ?');
            $consulta->execute(array($_GET['codigo']));
            header('Location: album.php?album=' . $_GET['album']);
            break;
        case 'editar':
            $consulta = $conexion->prepare('SELECT * FROM canciones WHERE codigo = ?');
            $consulta->execute(array($_GET['codigo']));
            $tema = $consulta->fetch();
            $_POST['codigo'] = $tema['codigo'];
            $_POST['titulo'] = $tema['titulo'];
            $_POST['minutos'] = (int) floor($tema['duracion'] / 60);
            $_POST['segundos'] = $tema['duracion'] % 60;
            break;
        case 'confirmar':
            $consulta = $conexion->prepare('SELECT * FROM canciones WHERE codigo = ?');
            $consulta->execute(array($_GET['codigo']));
            $tema = $consulta->fetch();
            $_POST['codigo'] = $tema['codigo'];
            $_POST['titulo'] = $tema['titulo'];
            break;
        default:
            header('Location: redirect.html');
            exit;
    }
}

// Cierra la conexión con la base de datos
$conexion = null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <a id="volver" href="grupos.php?grupo=<?= $grupo['grupo'] ?>">Volver</a>
    <table>
        <tr>
            <th>Título</th>
            <th>Duración</th>
            <th colspan="2">Acción</th>
        </tr>
        <?php
        /*
            Muestra las canciones del álbum en forma de tabla con Título y
            duración de la canción, tras la información, muestra un icono de
            borrar y otro de editar. Si no hay canciones, muestra un mensaje
            de que no hay canciones.
        */
        if ($consulta->rowCount() == 0) {
            echo '<tr><td colspan="4">Este álbum no tiene canciones registradas!</td></tr>';
        } else {
            while ($fila = $resultado->fetch()) {
                $fila['duracion'] = floor($fila['duracion'] / 60) . ':' . str_pad($fila['duracion'] % 60, 2, '0', STR_PAD_LEFT);
                echo '<tr>';
                echo '<td>' . $fila['titulo'] . '</td>';
                echo '<td>' . $fila['duracion'] . '</td>';
                echo '<td><a href="album.php?album=' . $_GET['album'] . '&accion=confirmar&codigo=' . $fila['codigo'] . '">
                <img src="img/delete.svg" alt="Borrar"></a></td>';
                echo '<td><a href="album.php?album=' . $_GET['album'] . '&accion=editar&codigo=' . $fila['codigo'] . '">
                <img src="img/edit.svg" alt="Modificar"></a></td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
    <div>
        <form action="#" method="POST">
            <fieldset>
                <legend>
                    <?php
                    /*
                        Si la acción es editar, muestra ''Editar canción'', si no,
                        muestra ''Insertar canción''.
                    */
                    if (isset($_GET['accion']) && $_GET['accion'] == 'editar') {
                        echo 'Editar canción';
                    } else {
                        echo 'Insertar canción';
                    }
                    ?>

                </legend>
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="<?= $_POST['titulo'] ?? '' ?>" required>
                <?= isset($error['titulo']) ? (is_bool($error['titulo']) ? '' : '<span class="error">' . $error['titulo']) . '</span>' : '' ?><br>
                <label for="duracion">Duración</label>
                <input type="number" name="minutos" id="minutos" min="0" value="<?= $_POST['minutos'] ?? '0' ?>" required> :
                <input type="number" name="segundos" id="segundos" min="0" value="<?= $_POST['segundos'] ?? '00' ?>" required>
                <?= isset($error['duracion']) ? (is_bool($error['duracion']) ? '' : '<span class="error">' . $error['duracion']) . '</span>' : '' ?><br>

                <?php
                /*
                    Si la acción es editar, muestra un botón de 'Cancelar' que
                    redirige a album.php?album=CODIGO y un botón de 'Modificar',
                    si no, muestra un botón
                    de 'Insertar'.
                */
                $accion = 'Insertar';
                if (isset($_GET['accion']) && $_GET['accion'] == 'editar') {
                    $accion = 'Modificar';
                    echo '<input type="hidden" name="codigo" id="codigo" value="' . $_GET['codigo'] . '">';
                    echo '<a class="myButton "href="album.php?album=' . $_GET['album'] . '">Cancelar</a>';
                } elseif (isset($_GET['accion']) && $_GET['accion'] == 'confirmar') {
                    echo '<fieldset>
                            <legend>Confirmar</legend>
                            <p>¿Estás seguro de que quieres borrar el álbum <b>' . $_POST['titulo'] . '</b>?</p>
                            <input type="hidden" name="codigo" id="codigo" value="' . $_GET['codigo'] . '">
                            <a class="myButton "href="album.php?album=' . $_GET['album'] . '">Cancelar</a>
                            <a class="myButton "href="album.php?album=' . $_GET['album'] . '&accion=borrar&codigo=' . $_GET['codigo'] . '">Borrar</a>
                        </fieldset>';
                }
                if (!(isset($_GET['accion']) && $_GET['accion'] == 'confirmar')) echo '<input type="submit" value="' . $accion . '">';
                ?>
            </fieldset>
        </form>
    </div>
</body>

</html>