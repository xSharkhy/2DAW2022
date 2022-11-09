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
    }
    // Si la acción es 'modificar', modifica el grupo en la base de datos
    else if ($_GET['accion'] == 'modificar') {

        $consulta = $conexion->prepare('UPDATE grupos SET nombre = ?, genero = ?, pais = ?, inicio = ? WHERE codigo = ?;');
        $consulta->execute(array($_POST['nombre'], $_POST['genero'], $_POST['pais'], $_POST['inicio'], $_POST['codigo']));
    } else {
        // Si la acción no es válida, redirige a una página segura
        header('Location: redirect.html');
        exit;
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
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div>
        <ol>
            <?php
            // Muestra los grupos en forma de lista ordenada
            // Tras el nombre del grupo, muestra un icono de borrar y otro de modificar
            foreach ($resultado as $fila)
                echo '<li><a href="grupos.php?codigo=' . $fila['codigo'] . '">' . $fila['nombre'] . '</a>
                <a href="index.php?accion=borrar"
                onclick="return confirm(\'¿Estás seguro de que quieres borrar el grupo ' . $fila['nombre'] . '?\')">
                <img src="img/delete.svg" alt="Borrar"></a>
                <a href="index.php?accion=modificar&codigo=' . $fila['codigo'] . '">
                <img src="img/edit.svg" alt="Modificar"></a></li>';
            ?>
        </ol>
    </div>
    <div>
        <form action="index.php?accion=insertar" method="post">
            <fieldset>
                <legend>
                    <?php
                    // Si la acción es 'modificar', muestra 'Modificar grupo'
                    // Si no, muestra 'Insertar grupo'
                    if (isset($_GET['accion']) && $_GET['accion'] == 'modificar')
                        echo 'Modificar grupo';
                    else
                        echo 'Insertar grupo';
                    ?>
                </legend>
                <input type="hidden" name="codigo" id="codigo" value="<?= $_GET['codigo'] ?? '' ?>"><br>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required><br>
                <label for="genero">Género</label>
                <input type="text" name="genero" id="genero" required><br>
                <label for="pais">País</label>
                <input type="text" name="pais" id="pais" required><br>
                <label for="inicio">Año de inicio</label>
                <input type="number" name="inicio" id="inicio" min="999" max="2022" required><br>
                <?php
                // Si la acción es 'modificar', muestra un botón de 'Cancelar' que redirige a index.php y un botón de 'Modificar'
                // Si no, muestra un botón de 'Insertar'
                if (isset($_GET['accion']) && $_GET['accion'] == 'modificar')
                    echo '<a id="cancelBtn" href="index.php">Cancelar</a>
                    <input type="submit" value="Modificar">';
                else
                    echo '<input type="submit" value="Insertar">';
                ?>
            </fieldset>
        </form>
    </div>
</body>

</html>