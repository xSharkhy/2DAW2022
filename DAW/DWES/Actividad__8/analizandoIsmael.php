<?php

$frase = "Un programador es la persona considerada experta en ser capaz de sacar, despues de innumerables tecleos, una serie infinita de respuestas incomprensibles calculadas con precision micrometrica a partir de vagas asunciones basadas en discutibles cifras tomadas de documentos inconcluyentes y llevados a cabo con instrumentos de escasa precision, por personas de fiabilidad dudosa y cuestionable mentalidad con el proposito declarado de molestar y confundir al desesperado e indefenso departamento que tuvo la mala fortuna de pedir la informacion en primer lugar.";

echo $frase . "<br><hr>";

echo strrev($frase) . "<br><hr>";

$palabra = "cifras";
echo $palabra . " está en la posición " . strrpos($frase, $palabra) . "<br><hr>";

echo explode("cabo", $frase)[1] . "<br><hr>";

echo "\"de\" sale " . substr_count($frase, "de") . " veces<br><hr>";
