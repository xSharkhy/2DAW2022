<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
    <style>
        table {
            border-collapse: collapse;
        }

        td {
            width: 50px;
            height: 50px;
            text-align: center;
        }

        tr:nth-child(odd) {
            background-color: palegreen;
        }

        tr:nth-child(even) {
            background-color: palegoldenrod;
        }

        tr:first-child td:first-child {
            background-color: palevioletred;
        }

        td:first-child, tr:first-child {
            background-color: lightblue;
        }
    </style>
</head>
<body>
<table border="1">
    <?php
    for ($i = 0; $i <= 10; $i++) {
        if ($i == 0) {
            ?>
            <tr>
                <td>x</td>
                <?php
                for ($j = 1; $j <= 10; $j++) {
                    ?>
                    <td><?= $j ?></td>
                    <?php
                }
                ?>
            </tr>
            <?php
            continue;
        }
        ?>
        <tr>
            <td><?= $i ?></td>
            <?php
            for ($j = 1; $j <= 10; $j++) {
                ?>
                <td><?= $i * $j ?></td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>