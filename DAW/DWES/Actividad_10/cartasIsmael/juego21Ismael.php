<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imatges/luffy.jpg" type="image/x-icon">
    <title>DAW 2022/23</title>
</head>

<body id="topPage" class="blackJack">
<h1>BlackJack</h1>
<?php require_once("PHP/header.inc.php") ?>
<?php require("PHP/cartas.inc.php") ?>
<main>
    <?php



    shuffle($cartas);
    $banca = ["puntuacion" => 0];

    for ($i = 0; $i < 2; $i++) {
        $carta = array_pop($cartas);
        $jugadores[0][] = $carta;
        $carta = array_pop($cartas);
        $jugadores[1][] = $carta;
        $carta = array_pop($cartas);
        $jugadores[2][] = $carta;
        $carta = array_pop($cartas);
        $jugadores[3][] = $carta;
        $carta = array_pop($cartas);
        $jugadores[4][] = $carta;
        $carta = array_pop($cartas);
        $banca[] = $carta;
    }

    ?>
    <div class="flex__container">
        <div class="flex__item">
            <?php
            for ($i = 0; $i < 2; $i++) echo '<img class="carta banca" src="imatges/cartas/' . $banca[$i]["imagen"] .
                '" alt="' . $banca[$i]["valor"] . ' de ' . $banca[$i]["palo"] . '">';
            ?>
            <h2>Banca</h2>
        </div>
        <div class="flex__item flex__container">
            <?php
            for ($i = 0; $i < 5; $i++) {
                echo '<div class="flex__item jugadores">';
                for ($j = 0; $j < 2; $j++) {
                    echo '<img class="carta" src="imatges/cartas/' . $jugadores[$i][$j]["imagen"] .
                        '" alt="' . $jugadores[$i][$j]["valor"] . ' de ' . $jugadores[$i][$j]["palo"] . '">';
                }
                echo '<h2>' . $jugadores[$i]["nombre"] . '</h2>';

                echo '</div>';
            }
            ?>
        </div>
    </div>
</main>
</body>

</html>
