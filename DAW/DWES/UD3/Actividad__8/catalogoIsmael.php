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
    // Escaneamos el directorio para encontrar todas las imágenes. Omitimos la marca de agua.
    // Por cada imágen, creamos una petición GET para añadir la marca de agua.
    // Mostramos las imágenes con la marca de agua.
    $coleccion = scandir('img');
    foreach ($coleccion as $imagen)
        if ($imagen != '.' && $imagen != '..' && $imagen != 'marca.png')
            echo '<img src="marcaIsmael.php?img=' . $imagen . '" alt="img/' . $imagen . '" width="200"><br>';
    ?>
</body>

</html>