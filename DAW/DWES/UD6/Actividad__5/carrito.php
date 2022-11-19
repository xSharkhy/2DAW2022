<?php
require_once 'include/dbconnection.inc.php';
require_once 'include/autologin.inc.php';
require_once 'include/carritoLogica.inc.php';

// Si llega una acción y un id, se ejecuta la función carrito y se manda un
// párametro con la página desde la que se ha llamado a la función.
if (isset($_GET['act']) && isset($_GET['id'])) carrito('carrito.php');

// Si el usuario no está logueado, se le redirige a la página de login.
if (!isset($_SESSION['user']) || !isset($_SESSION['admin'])) header('Location: index.php');

/*
    Se muestra en forma de tabla el contenido del carrito.
    Por cada producto, se realiza una consulta a la base de datos para obtener los datos del producto.
    Se muestra el nombre del producto, la cantidad y el precio.
    Además, se muestran las acciones de añadir, restar y eliminar producto.
*/

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
                $conexion = null;
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