<?php
require_once('include/personas.inc.php');
require_once('include/Persona.inc.php');

foreach ($personas as $persona) {
    $agenda[] = new Persona($persona['idContacto'], $persona['nombre'], $persona['apellido1'], $persona['apellido2'], $persona['telefono']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
</head>

<body>
    <?php foreach ($agenda as $persona) echo '<div class="persona">' . $persona . '</div>' ?>
</body>

</html>