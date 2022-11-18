<?php
require_once 'include/dbconnection.inc.php';
session_start();

// Crea una consulta que muestre todos los productos de la tabla productos
$consultaProductos = $conexion->query('SELECT * FROM productos WHERE oferta != 0');

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