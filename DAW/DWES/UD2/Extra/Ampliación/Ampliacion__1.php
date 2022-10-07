<?php 

$var0 = 0;
$var1 = 1;
$aux = null;
for ($i=0; $i < 19; $i++) { 
    if ($i == 0) echo $var0 . " " . $var1 . " ";
    else {
        $aux = $var0 + $var1;
        $var0 = $var1;
        $var1 = $aux;
        echo $aux . " ";
    }
}