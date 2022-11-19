<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';
require_once 'include/carritoLogica.inc.php';

// Si llega una acción y un id, se ejecuta la función carrito y se manda un
// párametro con la página desde la que se ha llamado a la función.
if (isset($_GET['act']) && isset($_GET['id'])) carrito('ofertas.php');

// Crea una consulta que muestre todos los productos de la tabla productos
$consultaProductos = $conexion->query('SELECT * FROM productos WHERE oferta != 0;');

/*
    Si la consulta devuelve más de 0 resultados, se crea un array con los resultados
    de la consulta y se recorre con un whiñe para mostrar los productos.

    Si el usuario está logueado, además, se muestran los botones de control del carrito.
*/

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop OFERTAS | Ismael</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require_once 'include/header.inc.php'; ?>
    <main class="main__container">
        <h1>¡Oferta!</h1>
        <div class="productos__container">
            <?php while ($producto = $consultaProductos->fetch()) : ?>
                <div class="producto col-s-5 col-3">
                    <img src="img/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
                    <h4><?= $producto['nombre'] ?></h4>
                    <p><?= $producto['categoria'] ?></p>
                    <p><?= $producto['precio'] ?> € <b>-<?= $producto['oferta'] ?>%</b> </p>
                    <?php if (isset($_SESSION['user']) || isset($_SESSION['admin'])) : ?>
                        <a class="productLink" href="ofertas.php?act=add&id=<?= $producto['codigo'] ?>"><img src="img/mas.png"></a>
                        <a class="productLink" href="ofertas.php?act=substract&id=<?= $producto['codigo'] ?>"><img src="img/papelera.png"></a>
                        <a class="productLink" href="ofertas.php?act=remove&id=<?= $producto['codigo'] ?>"><img src="img/menos.png"></a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>

</html>