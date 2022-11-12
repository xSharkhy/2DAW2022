<?php
/*
    Conecta con la base de datos discografia con PDO y realiza la consulta que
    muestra el listado de grupos, si atrapa una excepción, redirige a una página segura
*/
const DB_DSN = 'mysql:host=localhost;dbname=discografia';
const DB_OPTIONS = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
try {
    $conexion = new PDO(DB_DSN, 'vetustamorla', '15151', DB_OPTIONS);
    $resultado = $conexion->query('SELECT * FROM grupos ORDER BY codigo;');
} catch (PDOException $e) {
    header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    exit;
}

// Si recibe datos por POST, comprueba si hay algún campo vacío y recorta los espacios restantes
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
        if (empty($_POST[$key])) $error[$key] = true;
    }
    // Si no hay ningún campo vacío, valida los datos
    if (!isset($error)) {
        preg_match('/^[0-9a-zA-ZÀ-ÿñÑçÇ\'\-\s]{1,50}$/', $_POST['nombre']) ? true : $error['nombre'] = 'El nombre de usuario debe tener  máximo 50 caracteres';
        preg_match('/^[0-9a-zA-ZÀ-ÿñÑçÇ\'\-\s]{1,50}$/', $_POST['genero']) ? true : $error['genero'] = 'El género debe tener máximo 50 caracteres';
        preg_match('/^[0-9a-zA-ZÀ-ÿñÑçÇ\'\-\s]{1,20}$/', $_POST['pais']) ? true : $error['pais'] = 'El país debe tener máximo 20 letras.';
        preg_match('/^\d{3,4}$/', $_POST['inicio']) ? true : $error['inicio'] = 'La fecha es incorrecta.';

        // Si se recibe el campo 'codigo', actualiza el registro
        if (isset($_POST['codigo']) && !isset($error)) {
            $consulta = $conexion->prepare('UPDATE grupos SET nombre = ?, genero = ?, pais = ?, inicio = ? WHERE codigo = ?;');
            $consulta->execute(array($_POST['nombre'], $_POST['genero'], $_POST['pais'], $_POST['inicio'], $_POST['codigo']));
            header('Location: index.php');
            exit;
            // Si no se recibe el campo 'codigo', inserta el registro
        } elseif (!isset($error)) {
            $consulta = $conexion->prepare('INSERT INTO grupos (nombre, genero, pais, inicio) VALUES (?, ?, ?, ?);');
            $consulta->execute(array($_POST['nombre'], $_POST['genero'], $_POST['pais'], $_POST['inicio']));
            header('Location: index.php');
            exit;
        }
    }
    // Si hay algún campo vacío, muestra un mensaje de error
    else echo '<span class="error">Rellena todos los campos.</span>';
}
// Si recibe la acción editar por GET con un codigo, rellena el formulario con los datos del registro por POST
elseif (isset($_GET['accion']) && $_GET['accion'] == 'editar' && isset($_GET['codigo'])) {
    $consulta = $conexion->prepare('SELECT * FROM grupos WHERE codigo = ?;');
    $consulta->execute(array($_GET['codigo']));
    $registro = $consulta->fetch();
    $_POST = $registro;
} // Si recibe la acción borrar por GET con un codigo, borra el registro
elseif (isset($_GET['accion']) && $_GET['accion'] == 'borrar' && isset($_GET['codigo'])) {
    $consulta = $conexion->prepare('DELETE FROM grupos WHERE codigo = ?;');
    $consulta->execute(array($_GET['codigo']));
    header('Location: index.php');
    exit;
} // Si recibe al acción confirmar por GET con un codigo, devolverá el nombre del grupo por POST
elseif (isset($_GET['accion']) && $_GET['accion'] == 'confirmar' && isset($_GET['codigo'])) {
    $consulta = $conexion->prepare('SELECT nombre FROM grupos WHERE codigo = ?;');
    $consulta->execute(array($_GET['codigo']));
    $registro = $consulta->fetch();
    $_POST['codigo'] = $_GET['codigo'];
    $_POST['nombre'] = $registro['nombre'];
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
    <title>Discografía | Ismael Morejón</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div>
        <?php
        /*
            Muestra los grupos en forma de lista ordenada, tras el nombre
            del grupo, muestra un icono de borrar y otro de editar. Si no
            hay grupos, muestra un mensaje.
        */
        if ($resultado->rowCount() > 0) {
            echo '<ol>';
            foreach ($resultado as $fila)
                echo '<li><a href="grupos.php?grupo=' . $fila['codigo'] . '">' . $fila['nombre'] . '</a>
                <a href="index.php?accion=confirmar&codigo=' . $fila['codigo'] . '">
                <img src="img/delete.svg" alt="Borrar"></a>
                <a href="index.php?accion=editar&codigo=' . $fila['codigo'] . '">
                <img src="img/edit.svg" alt="Modificar"></a></li>';
            echo '</ol>';
        } else echo '<p>No hay grupos.</p>';

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
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?= $_POST['nombre'] ?? '' ?>" required>
                <?= isset($error['nombre']) ? (is_bool($error['nombre']) ? '' : '<span class="error">' . $error['nombre']) . '</span>' : '' ?><br>
                <label for="genero">Género</label>
                <input type="text" name="genero" id="genero" value="<?= $_POST['genero'] ?? '' ?>" required>
                <?= isset($error['genero']) ? (is_bool($error['genero']) ? '' : '<span class="error">' . $error['genero']) . '</span>' : '' ?><br>
                <label for="pais">País</label>
                <input type="text" name="pais" id="pais" value="<?= $_POST['pais'] ?? '' ?>" required>
                <?= isset($error['pais']) ? (is_bool($error['pais']) ? '' : '<span class="error">' . $error['pais']) . '</span>' : '' ?><br>
                <label for="inicio">Año de inicio</label>
                <input type="number" name="inicio" id="inicio" min="999" max="2022" value="<?= $_POST['inicio'] ?? '' ?>" required>
                <?= isset($error['inicio']) ? (is_bool($error['inicio']) ? '' : '<span class="error">' . $error['inicio']) . '</span>' : '' ?><br>

                <?php
                /*
                    Si la acción es 'editar', muestra un botón de 'Cancelar' que
                    redirige a index.php y un botón de 'Modificar'.
                    Si la acción no es confirmar, muestra un botón de 'Insertar'
                */
                $accion = 'Insertar';
                if (isset($_GET['accion']) && $_GET['accion'] == 'editar') {
                    echo '<input type="hidden" name="codigo" id="codigo" value="' . $_GET["codigo"] . '">';
                    echo '<a class="myButton" href="index.php">Cancelar</a>';
                    $accion = 'Modificar';
                } else if (isset($_GET['accion']) && $_GET['accion'] == 'confirmar') {
                    echo '<fieldset>
                        <legend>Confirmar</legend>
                        <p>¿Estás seguro de que quieres borrar el grupo <b>' . $_POST['nombre'] . '</b>?</p>
                        <a class="myButton" href="index.php">Cancelar</a>
                        <a class="myButton" href="index.php?accion=borrar&codigo=' . $_GET['codigo'] . '">Borrar</a>
                    </fieldset>';
                }
                if (!(isset($_GET['accion']) && $_GET['accion'] == 'confirmar')) echo '<input type="submit" value="' . $accion . '">';
                ?>
            </fieldset>
        </form>
    </div>
</body>

</html>