<?php

function factorial($int) {
    $aux = 1;
    for ($i=1; $i <= $int; $i++) $aux *= $i;
    return $int . "! = " . $aux;
}

$int = 6;
echo factorial($int);