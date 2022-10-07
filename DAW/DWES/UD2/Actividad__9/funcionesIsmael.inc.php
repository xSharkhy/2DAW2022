<?php

function suma(int $num1, int $num2) {
    return $num1 + $num2;
}

function resta(int $num1, int $num2) {
    return $num1 - $num2;
}

function multiplicacion(int $num1, int $num2) {
    return $num1 * $num2;
}

function division(int $num1, int $num2) : float {
    if ($num2 == 0) return "ERROR! No se puede dividir entre 0";
    return $num1 / $num2;
}

function modulo(int $num1, int $num2) : int {
    if ($num2 == 0) return "ERROR! No se puede dividir entre 0";
    return $num1 % $num2;
}

function masGrande(int $num1, int $num2) {
    return $num1 == $num2 ? 'Ambos son iguales' : max($num1, $num2);
}

function parImpar(int $num1, int $num2) {
    return ($num1 % 2 == 0 ? $num1 . ' es par' : $num1 . ' es impar') . '<br>'
    . ($num2 % 2 == 0 ? $num2 . ' es par' : $num2 . ' es impar');
}

?>