<?php
require_once 'include/dbconnection.inc.php';
ini_set('session.name', 'SSID');
ini_set('session.cookie_httponly', 1);
session_start();

/*

if (!isset($_SESSION['user'])) {
    
} else {
    // Crea una consulta que muestre todos los productos de la tabla productos
    $consultaProductos = $conexion->query('SELECT * FROM productos');
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
        if (!isset($error)) {
            if (isset($_POST['codigo'])) {
                $consulta = $conexion->prepare('UPDATE grupos SET nombre = ?, genero = ?, pais = ?, inicio = ? WHERE codigo = ?;');
                $consulta->execute(array($_POST['nombre'], $_POST['genero'], $_POST['pais'], $_POST['inicio'], $_POST['codigo']));
                header('Location: index.php');
                exit;
            } else {
                $consulta = $conexion->prepare('INSERT INTO grupos (nombre, genero, pais, inicio) VALUES (?, ?, ?, ?);');
                $consulta->execute(array($_POST['nombre'], $_POST['genero'], $_POST['pais'], $_POST['inicio']));
                header('Location: index.php');
                exit;
            }
        }
    }
    // Si hay algún campo vacío, muestra un mensaje de error
    else echo '<span class="error">Rellena todos los campos.</span>';
}
// Si recibe la acción editar por GET con un codigo, rellena el formulario con los datos del registro por POST
if (isset($_GET['act']) && isset($_GET['id'])) {
    switch ($_GET['act']) {
        case 'add':
            
            break;
        case 'emp':
            
            break;
        case 'sub':
            
            break;
        default:
            header('Location: redirect.php');
            exit;
    }
}

*/

// Crea una consulta que muestre todos los productos de la tabla productos
$consultaProductos = $conexion->query('SELECT * FROM productos');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop INICIO | Ismael</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once 'include/header.inc.php'; ?>
    <main class="main__container">
        <h1>Productos</h1>
        <div class="productos__container">
            <?php
            // Muestra los productos
            while ($producto = $consultaProductos->fetch()) {
                echo '<div class="producto col-s-5 col-3">';
                echo '<img src="img/' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
                echo '<h5>' . $producto['nombre'] . '</h5>';
                echo '<p>' . $producto['categoria'] . '</p>';
                echo '<p>' . $producto['precio'] . '€</p>';
                echo '<a class="productLink" href="index.php?act=add&id=' . $producto['codigo'] . '"><img src="img/mas.png"></a>';
                echo '<a class="productLink" href="index.php?act=emp&id=' . $producto['codigo'] . '"><img src="img/papelera.png"></a>';
                echo '<a class="productLink" href="index.php?act=sub&id=' . $producto['codigo'] . '"><img src="img/menos.png"></a>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>
</html>