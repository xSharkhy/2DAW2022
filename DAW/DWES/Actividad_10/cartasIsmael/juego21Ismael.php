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

    function conteo($mano) {
        $suma = 0;
        $as = 0;
        foreach ($mano as $carta) {
            $valor = $carta["valor"];
            if ($valor == "J" || $valor == "Q" || $valor == "K") {
                $suma += 10;
            } else if ($valor == "A") {
                $as++;
            } else {
                $suma += $valor;
            }            
        }

        for ($i = 0; $i < $as; $i++) {
            if ($suma + 11 > 21) {
                $suma += 1;
            } else {
                $suma += 11;
            }
        }

        return $suma;
    }

    function resultado($jugador, $banca) {
        if ($jugador > 21) {
            return "¡PIERDE!";
        } else if ($jugador > $banca && $jugador <= 21) {
            return "¡GANA!";
        } else if ($jugador < $banca && $banca > 21) {
            return "¡GANA!";
        } else if ($jugador < $banca) {
            return "¡PIERDE!";
        } else {
            return "Empate";
        }
    }

    shuffle($cartas);
    $banca = ["puntuacion" => 0, "gana" => false];

    for ($i = 0; $i < 2; $i++) {
        for ($j = 0; $j < count($jugadores); $j++) {
            $jugadores[$j]["mano"][] = array_pop($cartas);
        }
        $banca["mano"][] = array_pop($cartas);
    }

    for ($i=0; $i < count($jugadores); $i++) { 
        $jugadores[$i]["puntuacion"] = conteo($jugadores[$i]["mano"]);
    }
    $banca["puntuacion"] = conteo($banca["mano"]);

    $i = 0;
    while ($i < 5) {
        if ($banca["puntuacion"] < 14) {
            $banca["mano"][] = array_pop($cartas);
            $banca["puntuacion"] = conteo($banca["mano"]);
        }
        if ($jugadores[$i]["puntuacion"] < 14) {
            $jugadores[$i]["mano"][] = array_pop($cartas);
            $jugadores[$i]["puntuacion"] = conteo($jugadores[$i]["mano"]);
        } else {
            $i++;
        }
    }



    ?>
    <div class="flex__container">
        <div class="flex__item">
            <?php
            for ($i = 0; $i < count($banca["mano"]); $i++) echo '<img class="carta banca" src="imatges/cartas/' . $banca["mano"][$i]["imagen"] .
                '" alt="' . $banca["mano"][$i]["valor"] . ' de ' . $banca["mano"][$i]["palo"] . '">';
            ?>
            <h2>Banca</h2>
            <p>Puntuación: <?php echo $banca["puntuacion"] ?></p>
        </div>
        <div class="flex__item flex__container">
            <?php
            for ($i = 0; $i < 5; $i++) {
                echo '<div class="flex__item jugadores">';
                for ($j = 0; $j < count($jugadores[$i]["mano"]); $j++) {
                    echo '<img class="carta" src="imatges/cartas/' . $jugadores[$i]["mano"][$j]["imagen"] .
                        '" alt="' . $jugadores[$i]["mano"][$j]["valor"] . ' de ' . $jugadores[$i]["mano"][$j]["palo"] . '">';
                }
                echo '<h2>' . $jugadores[$i]["nombre"] . '</h2>';
                echo '<p>Puntuación: ' . $jugadores[$i]["puntuacion"] . " " . resultado($jugadores[$i]["puntuacion"], $banca["puntuacion"]) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
        
    </div>
</main>
</body>

</html>
