<?php

function factorial($int) {
    if ($int == 0) return 1;
    else return $int * factorial($int - 1);
}

$int = 6;
echo "$int! = " . factorial($int);