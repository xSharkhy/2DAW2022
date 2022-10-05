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

<body id="topPage">
<h1>La Carta más alta</h1>
<?php require_once("PHP/header.inc.php") ?>
<?php require("PHP/cartas.inc.php") ?>
<main id="cartaAlta">
    <?php
    shuffle($cartas);
    shuffle($jugadores);
    $jugador1 = $jugadores[0];
    $jugador2 = $jugadores[1];

    for ($i = 0; $i < 10; $i++) {
        $carta = array_pop($cartas);
        $jugador1[] = $carta;
        $carta = array_pop($cartas);
        $jugador2[] = $carta;
    }

    $control = [];

    for ($i = 0; $i < 10; $i++) {
        $valor1 = $jugador1[$i]["valor"] == "J" ? 11 : ($jugador1[$i]["valor"] == "Q" ? 12 : ($jugador1[$i]["valor"] == "K" ? 13 : $jugador1[$i]["valor"]));
        $valor2 = $jugador2[$i]["valor"] == "J" ? 11 : ($jugador2[$i]["valor"] == "Q" ? 12 : ($jugador2[$i]["valor"] == "K" ? 13 : $jugador2[$i]["valor"]));
        if ($valor1 > $valor2) {
            $jugador1["puntuacion"] += 2;
            $control[$i] = "j1";
        } else if ($valor1 < $valor2) {
            $jugador2["puntuacion"] += 2;
            $control[$i] = "j2";
        } else {
            $jugador1["puntuacion"] += 1;
            $jugador2["puntuacion"] += 1;
            $control[$i] = "empate";
        }
    }

    ?>
    <h2>Jugador 1: <?= $jugador1["nombre"] ?></h2>
    <div class="mano">
        <img class="jugador" src="imatges/jugadores/<?= $jugador1["foto"] ?>" alt="Foto de <?= $jugador1["nombre"] ?>">
        <?php
        for ($i = 0; $i < 10; $i++) {
            echo '<img class="carta jugador1 ' . $control[$i] . '" src="imatges/cartas/' . $jugador1[$i]["imagen"] . '" alt="' . $jugador1[$i]["valor"] . ' de ' . $jugador1[$i]["palo"] . '">';
        }
        ?>

    </div>
    <h2>Jugador 2: <?= $jugador2["nombre"] ?></h2>
    <div class="mano">
        <img class="jugador" src="imatges/jugadores/<?= $jugador2["foto"] ?>" alt="Foto de <?= $jugador2["nombre"] ?>">
        <?php
        for ($i = 0; $i < 10; $i++) {
            echo '<img class="carta jugador2 ' . $control[$i] . '" src="imatges/cartas/' . $jugador2[$i]["imagen"] . '" alt="' . $jugador2[$i]["valor"] . ' de ' . $jugador2[$i]["palo"] . '">';
        }
        ?>
    </div>

    <h2>Resultado de la partida:</h2>
    <?= $jugador1["nombre"] ?>: <?= $jugador1["puntuacion"] ?> puntos<br>
    <?= $jugador2["nombre"] ?>: <?= $jugador2["puntuacion"] ?> puntos<br>
    <div class="ganador">
        <?php
        $ganador = $jugador1["puntuacion"] == $jugador2["puntuacion"] ? "¡EMPATE!" : ($jugador1["puntuacion"] > $jugador2["puntuacion"] ? $jugador1["nombre"] : $jugador2["nombre"]);
        if ($ganador == "¡EMPATE!") {
            echo $ganador . '<br>';
            echo '<img class="jugador" src="imatges/Sobera.png" alt="Empate">';
        } else {
            echo "¡El ganador es $ganador!<br>";
            echo '<img class="jugador" src="imatges/jugadores/' . $ganador . '.png" alt="Foto de <?= $ganador ?>">';
        }
        ?>

    </div>
</main>
</body>

</html>
