<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';

// Crea una consulta que muestre todos los productos de la tabla productos
$consultaProductos = $conexion->query('SELECT * FROM productos WHERE oferta != 0;');

if (isset($_SESSION['user']) || isset($_SESSION['admin'])) :
    if (isset($_GET['act']) && isset($_GET['id'])) {
        switch ($_GET['act']) {
            case 'add':
                if (isset($_SESSION['carrito']))
                    if (isset($_SESSION['carrito'][$_GET['id']])) $_SESSION['carrito'][$_GET['id']]++;
                    else $_SESSION['carrito'][$_GET['id']] = 1;
                else $_SESSION['carrito'][$_GET['id']] = 1;

                $_SESSION['carrito']['timer'] = time() + 60 * 10;
                break;
                //Si la acción es eliminar se elimina el producto del carrito
            case 'substract':
                if (isset($_SESSION['carrito'][$_GET['id']]))
                    if ($_SESSION['carrito'][$_GET['id']] > 1) $_SESSION['carrito'][$_GET['id']]--;
                    else unset($_SESSION['carrito'][$_GET['id']]);
                break;
                //Si la acción es vaciar se vacía el carrito
            case 'remove':
                if (isset($_SESSION['carrito'][$_GET['id']])) unset($_SESSION['carrito'][$_GET['id']]);
                break;
        }
        header('Location: ofertas.php');
    }
endif;

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