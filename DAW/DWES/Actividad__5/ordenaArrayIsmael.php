<?php
$intArray = [29, 64, 69, 98, 32, 70, 89, 48, 74, 55];
foreach ($intArray as $value) echo $value . " ";

echo "<br>";

for ($i = 0; $i < count($intArray) - 1; $i++) {
    $min = $i;
    for ($j = $i + 1; $j < count($intArray); $j++) {
        if ($intArray[$min] > $intArray[$j]) {
            $min = $j;
        }
    }
    $aux = $intArray[$min];
    $intArray[$min] = $intArray[$i];
    $intArray[$i] = $aux;
}

foreach ($intArray as $value) echo $value . " ";