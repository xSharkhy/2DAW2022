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
    "nombre" => ["Ismael", "Ismael", "Ismael", "Ismael"],
    "apellidos" => ["Morejón Blasco", "Morejón Blasco", "Morejón Blasco", "Morejón Blasco"],
    "email" => ["is@mael.com", "is@mael.com", "is@mael.com", "is@mael.com"],
    "fechaNacimiento" => ["19 de septiembre de 2001", "19 de septiembre de 2001", "19 de septiembre de 2001", "19 de septiembre de 2001"],
    "telefono" => ["666666666", "666666666", "666666666", "666666666"],
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
    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Fecha de nacimiento</th>
        <th>Teléfono</th>
    </tr>
    <?php
    for ($i = 0; $i < count($arrayFicha["nombre"]); $i++) {
        echo "<tr>";
        echo "<td>" . $arrayFicha["nombre"][$i] . "</td>";
        echo "<td>" . $arrayFicha["apellidos"][$i] . "</td>";
        echo "<td>" . $arrayFicha["email"][$i] . "</td>";
        echo "<td>" . $arrayFicha["fechaNacimiento"][$i] . "</td>";
        echo "<td>" . $arrayFicha["telefono"][$i] . "</td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>