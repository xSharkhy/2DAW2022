<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
</head>
<body>
<ul>
    <?php
    for ($i = 1; $i <= 5; $i++) {
        ?>
        <li><a href="#sec<?= $i ?>">Sección <?= $i ?></a></li>
        <?php
    }
    ?>
</ul>
<section>
    <article id="sec1">
        <h1>Negativo - Cero - Positivo</h1>
        <?php $_anInt = -1;
        if ($_anInt < 0) {
            echo '<p>El número ' . $_anInt . ' es negativo</p>';
        } else if ($_anInt == 0) {
            echo '<p>El número ' . $_anInt . ' es cero</p>';
        } else {
            echo '<p>El número ' . $_anInt . ' es positivo</p>';
        }
        ?>
    </article>
    <article id="sec2">
        <h1>Nota</h1>
        <p>Martina Fdez tiene una nota de:</p>
        <?php
        $_anInt = 5;
        switch ($_anInt) {
            case '0':
            case '1':
            case '2':
                echo '<p>Insuficiente</p>';
                break;
            case '3':
            case '4':
                echo '<p>Necesita mejorar</p>';
                break;
            case '5':
                echo '<p>Aprobado justito</p>';
                break;
            case '6':
                echo '<p>Aprobado</p>';
                break;
            case '7':
                echo '<p>Notable bajo</p>';
                break;
            case '8':
                echo '<p>Notable</p>';
                break;
            case '9':
            case '10':
                echo '<p>Sobresaliente</p>';
                break;
            default:
                echo '<p>Valor no válido</p>';
                break;
        }
        ?>
    </article>
    <article id="sec3">
        <?php $_anInt = 7 ?>
        <h1>Tabla de multiplicar del <?= $_anInt ?></h1>
        <table border="1">
            <tr>
                <td>x</td>
                <td><?= $_anInt ?></td>
            </tr>
            <?php for ($i = 1; $i <= 20; $i++) { ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $i * $_anInt ?></td>
                </tr>
            <?php } ?>
        </table>
    </article>
    <article id="sec4">
        <?php
        $_filas = 5;
        $_columnas = 8
        ?>
        <h1>Tabla de <?= $_filas ?> y <?= $_columnas ?> columnas</h1>
        <table border="1">
            <?php
            for ($i = 1; $i <= $_filas; $i++) {
                echo '<tr>';
                for ($j = 1; $j <= $_columnas; $j++) {
                    echo '<td>' . $i . ' x ' . $j . '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
    </article>
    <article id="sec5">
        <h1>Cálculo del cambio</h1>
        <p>Total a devolver: <?= $_cambio = 783 ?></p>
        <?php $_resto = intval($_cambio / 500) ?>
        <p>Billetes de 500: <?= $_resto ?></p>
        <?php $_cambio %= 500 ?>

        <?php $_resto = intval($_cambio / 200) ?>
        <p>Billetes de 200: <?= $_resto ?></p>
        <?php $_cambio %= 200 ?>

        <?php $_resto = intval($_cambio / 100) ?>
        <p>Billetes de 100: <?= $_resto ?></p>
        <?php $_cambio %= 100 ?>

        <?php $_resto = intval($_cambio / 50) ?>
        <p>Billetes de 50: <?= $_resto ?></p>
        <?php $_cambio %= 50 ?>

        <?php $_resto = intval($_cambio / 20) ?>
        <p>Billetes de 20: <?= $_resto ?></p>
        <?php $_cambio %= 20 ?>

        <?php $_resto = intval($_cambio / 10) ?>
        <p>Billetes de 10: <?= $_resto ?></p>
        <?php $_cambio %= 10 ?>

        <?php $_resto = intval($_cambio / 5) ?>
        <p>Billetes de 5: <?= $_resto ?></p>
        <?php $_cambio %= 5 ?>

        <?php $_resto = intval($_cambio / 2) ?>
        <p>Monedas de 2: <?= $_resto ?></p>
        <?php $_cambio %= 2 ?>

        <p>Monedas de 1: <?= $_resto ?></p>
    </article>
</section>
</body>
</html>