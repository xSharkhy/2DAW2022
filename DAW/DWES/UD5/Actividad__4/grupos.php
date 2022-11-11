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
$consulta->execute(array($_GET['grupo']));

// Si no se ha recibido el código del grupo o no es válido, redirige a la página principal
if (!isset($_GET['grupo']) || $consulta->rowCount() == 0) {
    header('Location: redirect.html');
    exit;
}

// Realiza la consulta de los álbumes del grupo
$consulta = $conexion->prepare('SELECT * FROM albumes WHERE grupo = ? ORDER BY anyo;');
$consulta->execute(array($_GET['grupo']));
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
    <ol>
        <?php
        // Muestra los álbumes en forma de lista ordenada
        foreach ($consulta as $fila)
            echo '<li><a href="album.php?codigo=' . $fila['codigo'] . '">' . $fila['titulo'] . '</a>
                <a href="index.php?accion=confirmar&codigo=' . $fila['codigo'] . '">
                <img src="img/delete.svg" alt="Borrar"></a>
                <a href="index.php?accion=editar&codigo=' . $fila['codigo'] . '">
                <img src="img/edit.svg" alt="Modificar"></a></li>';
        ?>
    </ol>
    <div>
        <form action="#" method="POST">
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
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="<?= $_POST['titulo'] ?? '' ?>" required>
                <?= isset($error['titulo']) ? (is_bool($error['titulo']) ? '' : '<span class="error">' . $error['titulo']) . '</span>' : '' ?><br>
                <label for="anyo">Año</label>
                <input type="text" name="anyo" id="anyo" value="<?= $_POST['anyo'] ?? '' ?>" required>
                <?= isset($error['anyo']) ? (is_bool($error['anyo']) ? '' : '<span class="error">' . $error['anyo']) . '</span>' : '' ?><br>
                <label for="formato">Formato</label>
                <input type="text" name="formato" id="formato" value="<?= $_POST['formato'] ?? '' ?>" required>
                <?= isset($error['formato']) ? (is_bool($error['formato']) ? '' : '<span class="error">' . $error['formato']) . '</span>' : '' ?><br>
                <label for="fechacompra">Fecha de Compra</label>
                <input type="date" name="fechacompra" id="fechacompra" value="<?= $_POST['fechacompra'] ?? '' ?>" required>
                <?= isset($error['fechacompra']) ? (is_bool($error['fechacompra']) ? '' : '<span class="error">' . $error['fechacompra']) . '</span>' : '' ?><br>
                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" min="0" step="0.01" value="<?= $_POST['precio'] ?? '' ?>" required>
                <?= isset($error['precio']) ? (is_bool($error['precio']) ? '' : '<span class="error">' . $error['precio']) . '</span>' : '' ?><br>

                <?php
                // Si la acción es 'editar', muestra un botón de 'Cancelar' que redirige a index.php y un botón de 'Modificar'
                // Si la acción no es confirmar, muestra un botón de 'Insertar'
                $accion = 'Insertar';
                if (isset($_GET['accion']) && $_GET['accion'] == 'editar') {
                    echo '<input type="hidden" name="codigo" id="codigo" value="' . $_GET["codigo"] . '">';
                    echo '<a id="myButton" href="index.php">Cancelar</a>';
                    $accion = 'Modificar';
                } else if (isset($_GET['accion']) && $_GET['accion'] == 'confirmar') {
                    echo '<fieldset>
                        <legend>Confirmar</legend>
                        <p>¿Estás seguro de que quieres borrar el grupo <b>' . $_POST['nombre'] . '</b>?</p>
                        <a id="myButton" href="index.php">Cancelar</a>
                        <a id="myButton" href="index.php?accion=borrar&codigo=' . $_GET['codigo'] . '">Borrar</a>
                    </fieldset>';
                }
                if (!(isset($_GET['accion']) && $_GET['accion'] == 'confirmar')) echo '<input type="submit" value="' . $accion . '">';
                ?>
            </fieldset>
        </form>
    </div>
</body>

</html>

</html>