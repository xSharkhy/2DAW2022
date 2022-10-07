<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
</head>
<body>
<?php
$arrayFicha = [
    "Nombre" => "Ismael",
    "Apellidos" => "Morejón Blasco",
    "eMail" => "is@mael.com",
    "Fecha de Nacimiento" => "19 de septiembre de 2001",
    "Telefono" => "666666666",
];
?>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 5px;
    }
</style>
<table>
    <?php foreach ($arrayFicha as $key => $value) { ?>
        <tr>
            <th><?= $key ?></td>
            <td><?= $value ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>