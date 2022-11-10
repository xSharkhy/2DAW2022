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

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
        if (empty($_POST[$key])) $error[$key] = true;
    }

    if (isset($error)) echo '<div class="error">Hay campos vacíos en el formulario</div>';
    else {
        preg_match('/^[a-zA-ZÀ-ÿñÑçÇ\'\-\s]{,50}$/', $_POST['nombre']) ? true : $error['nombre'] = 'El nombre de usuario debe tener  máximo 50 caracteres' . '<br>';
        preg_match('/^[a-zA-ZÀ-ÿñÑçÇ\'\-\s]{,50}$/', $_POST['genero']) ? true : $error['genero'] = 'El género debe tener máximo 50 caracteres' . '<br>';
        preg_match('/^[a-zA-ZÀ-ÿñÑçÇ\'\-\s]{,20}$/', $_POST['pais']) ? true : $error['pais'] = 'El apellido debe tener máximo 20 letras.' . '<br>';
        preg_match('/^\d{3,4}$/', $_POST['inicio']) ? true : $error['inicio'] = 'El apellido debe tener almenos 3 letras.' . '<br>';

        // Conecta a la base de datos y realiza la consulta, si atrapa una excepción, redirige a una página segura
        if (!isset($error)) {

            // Comprueba la acción recibida por GET
            if (isset($_GET['accion'])) {
                // Si la acción es 'insertar', inserta el grupo en la base de datos
                if ($_GET['accion'] == 'insertar') {
                    $consulta = $conexion->prepare('INSERT INTO grupos (nombre, genero, pais, inicio) VALUES (?, ?, ?, ?);');
                    $consulta->execute(array($_POST['nombre'], $_POST['genero'], $_POST['pais'], $_POST['inicio']));
                    header('Location: index.php');
                }
                // Si la acción es 'borrar', borra el grupo de la base de datos
                else if ($_GET['accion'] == 'borrar') {
                    $consulta = $conexion->prepare('DELETE FROM grupos WHERE codigo = ?;');
                    $consulta->execute(array($_GET['codigo']));
                    header('Location: index.php');
                }
                // Si la acción es 'editar', modifica el grupo en la base de datos
                else if ($_GET['accion'] == 'editar') {
                    // Seleciona el grupo de la base de datos y mandalo al value del input
                    $consulta = $conexion->prepare('SELECT * FROM grupos WHERE codigo = ?;');
                    $consulta->execute(array($_GET['codigo']));
                    $grupo = $consulta->fetch();
                    $_POST['nombre'] = $grupo['nombre'];
                    $_POST['genero'] = $grupo['genero'];
                    $_POST['pais'] = $grupo['pais'];
                    $_POST['inicio'] = $grupo['inicio'];
                }
                // Si se ha enviado el formulario, modifica el grupo en la base de datos
                else if ($_GET['accion'] == 'update') {
                    $consulta = $conexion->prepare('UPDATE grupos SET nombre = ?, genero = ?, pais = ?, inicio = ? WHERE codigo = ?;');
                    $consulta->execute(array($_POST['nombre'], $_POST['genero'], $_POST['pais'], $_POST['inicio'], $_POST['codigo']));
                    header('Location: index.php');
                } else if ($_GET['accion'] == 'confirmar') {
                    $consulta = $conexion->prepare('SELECT nombre FROM grupos WHERE codigo = ?;');
                    $consulta->execute(array($_GET['codigo']));
                    $grupo = $consulta->fetch();
                    $_POST['nombre'] = $grupo['nombre'];
                } else {
                    // Si la acción no es válida, redirige a una página segura
                    header('Location: redirect.html');
                    exit;
                }
            }
        }
    }
}

// Cierra la conexión con la base de datos
$conexion = null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos | Ismael Morejón</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div>
        <ol>
            <?php
            // Muestra los grupos en forma de lista ordenada
            // Tras el nombre del grupo, muestra un icono de borrar y otro de editar
            foreach ($resultado as $fila)
                echo '<li><a href="grupos.php?codigo=' . $fila['codigo'] . '">' . $fila['nombre'] . '</a>
                <a href="index.php?accion=confirmar&codigo=' . $fila['codigo'] . '">
                <img src="img/delete.svg" alt="Borrar"></a>
                <a href="index.php?accion=editar&codigo=' . $fila['codigo'] . '">
                <img src="img/edit.svg" alt="Modificar"></a></li>';
            ?>
        </ol>
    </div>
    <div>
        <form action="index.php?accion=<?= isset($_GET['accion']) ? 'update' : 'insertar' ?>#" method="post">
            <fieldset>
                <legend>
                    <?php
                    // Si la acción es 'editar', muestra 'Modificar grupo'
                    // Si no, muestra 'Insertar grupo'
                    if (isset($_GET['accion']) && $_GET['accion'] == 'editar')
                        echo 'Modificar grupo';
                    else
                        echo 'Insertar grupo';
                    ?>
                </legend>
                <input type="hidden" name="codigo" id="codigo" value="<?= $_GET['codigo'] ?? '' ?>"><br>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?= $_POST['nombre'] ?? '' ?>" required>
                <?= isset($error['nombre']) ? (is_bool($error['nombre']) ? '' : $error['nombre']) : '' ?><br>
                <label for="genero">Género</label>
                <input type="text" name="genero" id="genero" value="<?= $_POST['genero'] ?? '' ?>" required>
                <?= isset($error['genero']) ? (is_bool($error['genero']) ? '' : $error['genero']) : '' ?><br>
                <label for="pais">País</label>
                <input type="text" name="pais" id="pais" value="<?= $_POST['pais'] ?? '' ?>" required>
                <?= isset($error['pais']) ? (is_bool($error['pais']) ? '' : $error['pais']) : '' ?><br>
                <label for="inicio">Año de inicio</label>
                <input type="number" name="inicio" id="inicio" min="999" max="2022" value="<?= $_POST['inicio'] ?? '' ?>" required>
                <?= isset($error['inicio']) ? (is_bool($error['inicio']) ? '' : $error['inicio']) : '' ?><br>

                <?php
                // Si la acción es 'editar', muestra un botón de 'Cancelar' que redirige a index.php y un botón de 'Modificar'
                // Si no, muestra un botón de 'Insertar'
                if (isset($_GET['accion']) && $_GET['accion'] == 'editar') {
                    echo '<input type="hidden" name="codigo" id="codigo" value="' . $_GET["codigo"] . '">';
                    echo '<a id="myButton" href="index.php">Cancelar</a>';
                    echo '<input type="submit" value="Modificar">';
                } elseif (isset($_GET['accion']) && $_GET['accion'] == 'confirmar') {
                    echo '<fieldset>
                        <legend>Confirmar</legend>
                        <p>¿Estás seguro de que quieres borrar el grupo ' . $_POST['nombre'] . '?</p>
                        <a id="myButton" href="index.php">Cancelar</a>
                        <a id="myButton" href="index.php?accion=borrar&codigo=' . $_GET['codigo'] . '">Borrar</a>
                    </fieldset>';
                } else {
                    $_GET['accion'] = 'insertar';
                    echo '<input type="submit" value="Insertar">';
                }
                ?>
            </fieldset>
        </form>
    </div>
</body>

</html>