<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';

if (isset($_GET['act']) && isset($_GET['id'])) {
    switch ($_GET['act']) {
        case 'add':
            if (isset($_SESSION['carrito']))
                if (isset($_SESSION['carrito'][$_GET['id']])) $_SESSION['carrito'][$_GET['id']]++;
                else $_SESSION['carrito'][$_GET['id']] = 1;
            else $_SESSION['carrito'][$_GET['id']] = 1;

            $_SESSION['timer'] = time() + 60 * 10;
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
            if (count($_SESSION['carrito']) == 0) unset($_SESSION['carrito']);
            break;
    }
    header('Location: carrito.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop CARRITO | Ismael</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require_once 'include/header.inc.php'; ?>
    <main class="main__container">
        <h1>Carrito</h1>
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) :
                    $total = 0;
                    foreach ($_SESSION['carrito'] as $producto => $cantidad) :
                        $consultaProducto = $conexion->query("SELECT * FROM productos WHERE codigo = $producto;");
                        $producto = $consultaProducto->fetch();
                        $total += round(($producto['precio'] - ($producto['precio'] * $producto['oferta'] / 100)), 2) * $cantidad;
                ?>
                        <tr>
                            <td><img src="img/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>"></td>
                            <td><?= $producto['nombre'] ?></td>
                            <td><?= $producto['precio'] ?> €</td>
                            <td><?= $cantidad ?></td>
                            <td><?= round(($producto['precio'] - ($producto['precio'] * $producto['oferta'] / 100)), 2) * $cantidad ?> €</td>
                            <td>
                                <a href="carrito.php?act=add&id=<?= $producto['codigo'] ?>"><img src="img/mas.png"></a>
                                <a href="carrito.php?act=remove&id=<?= $producto['codigo'] ?>"><img src="img/papelera.png"></a>
                                <a href="carrito.php?act=substract&id=<?= $producto['codigo'] ?>"><img src="img/menos.png"></a>
                            </td>
                        </tr>
                <?php
                    endforeach;
                endif;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total</td>
                    <td><?= $total ?? '' ?>€</td>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>