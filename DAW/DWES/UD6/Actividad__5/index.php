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
            if (count($_SESSION['carrito']) == 1) unset($_SESSION['carrito']);
            break;
    }
    header('Location: index.php');
}
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
    <main class="main__container">';
        <?php
        if (isset($_SESSION['user']) || isset($_SESSION['admin'])) :
            // Crea una consulta que muestre todos los productos de la tabla productos
            $consultaProductos = $conexion->query('SELECT * FROM productos;'); ?>
            <h1>Productos</h1>
            <div class="productos__container">
                <?php while ($producto = $consultaProductos->fetch()) : ?>
                    <div class="producto col-s-5 col-3">
                        <img src="img/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
                        <h4><?= $producto['nombre'] ?></h4>
                        <p><?= $producto['categoria'] ?></p>
                        <p><?= $producto['precio'] ?> €</p>
                        <a class="productLink" href="index.php?act=add&id=<?= $producto['codigo'] ?>"><img src="img/mas.png"></a>
                        <a class="productLink" href="index.php?act=remove&id=<?= $producto['codigo'] ?>"><img src="img/papelera.png"></a>
                        <a class="productLink" href="index.php?act=substract&id=<?= $producto['codigo'] ?>"><img src="img/menos.png"></a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        else : ?>
            <h1>Registro</h1>
            <form action="registro.php" method="POST">
                <label for="mail">Email</label>
                <input type="email" name="mail" id="mail" required><br>
                <label for="user">Usuario</label>
                <input type="text" name="user" id="user" required><br>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required><br>
                <label for="repassword">Repite la Contraseña</label>
                <input type="password" name="repassword" id="repassword" required><br>
                <input type="submit" name="submit" value="Registrarse">
                <p>¿Ya tienes cuenta? <a href="login.php" id="loginB">Inicia sesión</a></p>
            </form>
            <a href="ofertas.php" id="ofertasImagen"><img src="img/oferta.png" alt="Link a Ofertas"></a>
        <?php endif; ?>
    </main>
</body>

</html>