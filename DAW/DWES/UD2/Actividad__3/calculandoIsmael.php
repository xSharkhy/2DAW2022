<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
</head>
<body>
    <?php
        $_num1 = 5;
        $_num2 = 5;
    ?>
    <h1>Calculadora</h1>
    <p>Número 1: <?= $_num1 ?></p>
    <p>Número 2: <?= $_num2 ?></p>
    <table border="1">
        <tr>
            <td>Suma</td>
            <td><?= $_num1 + $_num2 ?></td>
        </tr>
        <tr>
            <td>Resta</td>
            <td><?= $_num1 - $_num2 ?></td>
        </tr>
        <tr>
            <td>Multiplicación</td>
            <td><?= $_num1 * $_num2 ?></td>
        </tr>
        <tr>
            <td>División</td>
            <td><?= $_num1 / $_num2 ?></td>
        </tr>
        <tr>
            <td>Módulo</td>
            <td><?= $_num1 % $_num2 ?></td>
        </tr>
        <tr>
            <td>Más grande</td>
            <td><?= $_num1 == $_num2 ? 'Ambos son iguales' : max($_num1, $_num2) ?></td>
        </tr>
        <tr>
            <td>Par o impar</td>
            <td>
                <?= $_num1 % 2 == 0 ? $_num1 . ' es par' : $_num1 . ' es impar' ?><br>
                <?= $_num2 % 2 == 0 ? $_num2 . ' es par' : $_num2 . ' es impar' ?>
            </td>
        </tr>
    </table>
</body>
</html>