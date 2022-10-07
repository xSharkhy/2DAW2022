<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td { padding: 5px; }

        th { text-align: left; }
    </style>
</head>

<body>
    <?php

    $_GET['precio'] .= " €";
    $_GET['cantidad'] .= " unidades";
    
    echo '<table>';
    foreach ($_GET as $key => $value) {
        echo '<tr>';
        echo '<th>' . ucfirst($key) . '</th>';
        echo '<td>' . $value . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    ?>

</body>
</html>