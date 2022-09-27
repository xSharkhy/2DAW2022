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
$intArray = [29, 64, 69, 89, 29, 70, 89, 48, 74, 55];
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
?>
</body>
</html>