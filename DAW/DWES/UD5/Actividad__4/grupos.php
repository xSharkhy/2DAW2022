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

/*
    Comprueba si ha recibido el código del grupo por GET y comprueba si es un
    número entero. Si es correcto, validará mediante una consulta a la base de
    datos si existe el grupo. Si no existe, redirige a la página de error.
*/
if (isset($_GET['grupo']) && is_numeric($_GET['grupo'])) {
    $consulta = $conexion->prepare('SELECT * FROM grupos WHERE codigo = ?');
    $consulta->execute(array($_GET['grupo']));
    if ($consulta->rowCount() == 0) {
        header('Location: redirect.html');
        exit;
    }
} else {
    header('Location: redirect.html');
    exit;
}

// Realiza la consulta de los álbumes del grupo
$resultado = $conexion->prepare('SELECT * FROM albumes WHERE grupo = ? ORDER BY codigo;');
$resultado->execute(array($_GET['grupo']));

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
        if (empty($_POST[$key])) $error[$key] = true;
    }
    // Si no hay ningún campo vacío, valida los datos
    if (!isset($error)) {
        preg_match('/^[0-9a-zA-ZÀ-ÿñÑçÇ\'\-\s]{1,50}$/', $_POST['titulo']) ? true : $error['titulo'] = 'El título debe tener máximo 50 caracteres';
        preg_match('/^[0-9]{4}$/', $_POST['anyo']) ? true : $error['anyo'] = 'El año debe tener máximo 4 números.';
        preg_match('/^(dvd|cd|vinilo|mp3)$/i', $_POST['formato']) ? true : $error['formato'] = 'El formato debe ser CD, DVD, Vinilo o MP3.';
        preg_match('/^(0[1-9]|[12][0-9]|3[01])(\-|\.|\/)(0[1-9]|1[012])(\-|\.|\/)(19[0-9]{2}|20[01][0-9]|202[12])$/', $_POST['fechacompra']) ? true : $error['fechacompra'] = 'La fecha debe tener el formato DD/MM/YYYY';
        preg_match('/^\d+((\,|\.)\d{1,2})?$/', $_POST['precio']) ? true : $error['precio'] = 'El precio debe tener el formato 00,00';

        // Validamos la fecha de compra para poder insertarla en la base de datos
        if (!isset($error)) $_POST['fechacompra'] = date('Y-m-d', strtotime($_POST['fechacompra']));

        // Si se recibe el campo 'codigo', actualiza el registro
        if (isset($_POST['codigo']) && !isset($error)) {
            $consulta = $conexion->prepare('UPDATE albumes SET titulo = ?, anyo = ?, formato = ?, fechacompra = ?, precio = ? WHERE codigo = ?');
            $consulta->execute(array($_POST['titulo'], $_POST['anyo'], $_POST['formato'], $_POST['fechacompra'], $_POST['precio'], $_POST['codigo']));
            header('Location: grupos.php?grupo=' . $_GET['grupo']);
            exit;
            // Si no se recibe el campo 'codigo', inserta el registro
        } elseif (!isset($error)) {
            $consulta = $conexion->prepare('INSERT INTO albumes (titulo, anyo, formato, fechacompra, precio, grupo) VALUES (?, ?, ?, ?, ?, ?)');
            $consulta->execute(array($_POST['titulo'], $_POST['anyo'], $_POST['formato'], $_POST['fechacompra'], $_POST['precio'], $_GET['grupo']));
            header('Location: grupos.php?grupo=' . $_GET['grupo']);
            exit;
        }
    }
    // Si hay algún campo vacío, muestra un mensaje de error
    else echo '<span class="error">Rellena todos los campos.</span>';
}
// Si recibe la acción editar por GET con un codigo, rellena el formulario con los datos del registro por POST
if (isset($_GET['accion']) && $_GET['accion'] == 'editar' && isset($_GET['codigo'])) {
    $consulta = $conexion->prepare('SELECT * FROM albumes WHERE codigo = ?');
    $consulta->execute(array($_GET['codigo']));
    $registro = $consulta->fetch();
    $_POST = $registro;
    $_POST['fechacompra'] = date('d/m/Y', strtotime($_POST['fechacompra']));
} elseif (isset($_GET['accion']) && $_GET['accion'] == 'borrar' && isset($_GET['codigo'])) {
    $consulta = $conexion->prepare('DELETE FROM albumes WHERE codigo = ?');
    $consulta->execute(array($_GET['codigo']));
    header('Location: grupos.php?grupo=' . $_GET['grupo']);
    exit;
} elseif (isset($_GET['accion']) && $_GET['accion'] == 'confirmar' && isset($_GET['codigo'])) {
    $consulta = $conexion->prepare('SELECT titulo FROM albumes WHERE codigo = ?');
    $consulta->execute(array($_GET['codigo']));
    $registro = $consulta->fetch();
    $_POST['codigo'] = $_GET['codigo'];
    $_POST['titulo'] = $registro['titulo'];
}

// Cierra la conexión
$conexion = null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos | Ismael Morejón</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div>
        <?php
        /*
            Muestra los álbumes en forma de lista ordenada, tras el nombre
            del álbum, muestra un icono de borrar y otro de editar. Si el
            grupo no tiene álbumes, muestra un mensaje de que no tiene
            álbumes.
        */
        if ($resultado->rowCount() > 0) {
            echo '<ol>';
            foreach ($resultado as $fila)
                echo '<li><a href="album.php?album=' . $fila['codigo'] . '">' . $fila['titulo'] . '</a>
                <a href="grupos.php?grupo=' . $_GET['grupo'] . '&accion=confirmar&codigo=' . $fila['codigo'] . '">
                <img src="img/delete.svg" alt="Borrar"></a>
                <a href="grupos.php?grupo=' . $_GET['grupo'] . '&accion=editar&codigo=' . $fila['codigo'] . '">
                <img src="img/edit.svg" alt="Modificar"></a></li>';
            echo '</ol>';
        } else echo '<h3>Este grupo no tiene álbumes.</h3>';

        ?>
    </div>
    <div>
        <form action="#" method="POST">
            <fieldset>
                <legend>
                    <?php
                    /*
                        Si la acción es 'editar', muestra 'Modificar grupo'
                        Si no, muestra 'Insertar grupo'
                    */
                    if (isset($_GET['accion']) && $_GET['accion'] == 'editar')
                        echo 'Modificar grupo';
                    else
                        echo 'Insertar grupo';
                    ?>
                </legend>
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="<?= $_POST['titulo'] ?? '' ?>" required>
                <?= isset($error['titulo']) ? (is_bool($error['titulo']) ? '' : '<span class="error">' . $error['titulo']) . '</span>' : '' ?><br>
                <label for="anyo">Año</label>
                <input type="number" name="anyo" id="anyo" min="1000" max="9999" value="<?= $_POST['anyo'] ?? '' ?>" required>
                <?= isset($error['anyo']) ? (is_bool($error['anyo']) ? '' : '<span class="error">' . $error['anyo']) . '</span>' : '' ?><br>
                <label for="formato">Formato</label>
                <input type="text" name="formato" id="formato" value="<?= $_POST['formato'] ?? '' ?>" required>
                <?= isset($error['formato']) ? (is_bool($error['formato']) ? '' : '<span class="error">' . $error['formato']) . '</span>' : '' ?><br>
                <label for="fechacompra">Fecha de Compra</label>
                <input type="text" name="fechacompra" id="fechacompra" value="<?= $_POST['fechacompra'] ?? '' ?>" required>
                <?= isset($error['fechacompra']) ? (is_bool($error['fechacompra']) ? '' : '<span class="error">' . $error['fechacompra']) . '</span>' : '' ?><br>
                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" min="0" step="0.01" value="<?= $_POST['precio'] ?? '' ?>" required>
                <?= isset($error['precio']) ? (is_bool($error['precio']) ? '' : '<span class="error">' . $error['precio']) . '</span>' : '' ?><br>

                <?php
                /*
                    Si la acción es 'editar', muestra un botón de 'Cancelar' que
                    redirige a grupo.php?grupo=X y un botón de 'Modificar'.
                    Si la acción no es confirmar, muestra un botón de 'Insertar'
                */
                $accion = 'Insertar';
                if (isset($_GET['accion']) && $_GET['accion'] == 'editar') {
                    echo '<input type="hidden" name="codigo" id="codigo" value="' . $_GET["codigo"] . '">';
                    echo '<a class="myButton" href="grupos.php?grupo=' . $_GET['grupo'] . '">Cancelar</a>';
                    $accion = 'Modificar';
                } else if (isset($_GET['accion']) && $_GET['accion'] == 'confirmar') {
                    echo '<fieldset>
                        <legend>Confirmar</legend>
                        <p>¿Estás seguro de que quieres borrar el álbum <b>' . $_POST['titulo'] . '</b>?</p>
                        <a class="myButton" href="grupos.php?grupo=' . $_GET['grupo'] . '">Cancelar</a>
                        <a class="myButton" href="grupos.php?grupo=' . $_GET['grupo'] . '&accion=borrar&codigo=' . $_GET['codigo'] . '">Borrar</a>
                    </fieldset>';
                }
                if (!(isset($_GET['accion']) && $_GET['accion'] == 'confirmar')) echo '<input type="submit" value="' . $accion . '">';
                ?>
            </fieldset>
        </form>
    </div>
</body>

</html>