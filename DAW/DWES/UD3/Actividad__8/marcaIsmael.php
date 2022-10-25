<?php
// Creamos una variable con la marca de agua

$marcaAgua = imagecreatefrompng('img/marca.png');
imagealphablending($marcaAgua, false);
imagesavealpha($marcaAgua, true);
imagefilter($marcaAgua, IMG_FILTER_COLORIZE, 0, 0, 0, 55);

// Obtenemos la imágen mediante GET y colocamos la marca de agua
$image = imagecreatefrompng('img/' . $_GET['img']);
$destX = imagesx($image) - imagesx($marcaAgua) - 10;
$destY = imagesy($image) - imagesy($marcaAgua) - 10;
imagecopy($image, $marcaAgua, $destX, $destY, 0, 0, imagesx($marcaAgua), imagesy($marcaAgua));

// Mostramos la imágen
header('Content-Type: image/png');
imagepng($image);
