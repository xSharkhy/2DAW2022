<?php
$error = '';
if (isset($_POST['codigo']))
    preg_match('/^[a-zA-Z0-9]{5}$/', $_POST['codigo']) ? true : $error .= 'El código debe ser alfanumérico y de 5 caracteres' . '<br>';
if (isset($_POST['nombre']))
    preg_match('/[a-zA-Z]{3,}/', $_POST['nombre']) ? true : $error .= 'El nombre debe tener al menos 3 caracteres' . '<br>';
if (isset($_POST['precio']))
    preg_match('/^[0-9]{1,}(\.[0-9]{1,2})?$/', $_POST['precio']) ? true : $error .= 'El precio debe ser decimal' . '<br>';
if (isset($_POST['descripcion']))
    preg_match('/^(.|\s)*[a-zA-Z0-9]+(.|\s)*$/', $_POST['descripcion']) ? true : $error .= 'La descripción debe tener almenos 50 caracteres' . '<br>';
if (isset($_POST['fabricante']))
    preg_match('/^.*([a-zA-Z0-9]|.|\s){10,20}$/', $_POST['fabricante']) ? true : $error .= 'El fabricante debe tener entre 10 y 20 caracteres' . '<br>';
if (isset($_POST['cantidad']))
    preg_match('/^\d{1,}$/', $_POST['cantidad']) ? true : $error .= 'La cantidad debe ser decimal' . '<br>';
if (isset($_POST['fecha']))
    preg_match('/^(19[0-9]{2}|20[01][0-9]|202[12])(\-|\.|\/)(0[1-9]|1[012])(\-|\.|\/)(0[1-9]|[12][0-9]|3[01])$/', $_POST['fecha']) ? true : $error .= 'La fecha debe tener el formato DD/MM/YYYY' . '<br>';
if ($error != '')
    echo $error;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="#" method="POST">
        <input type="text" name="codigo" id="codigo" placeholder="Código"><br>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre"><br>
        <input type="number" min="0" step="any" name="precio" id="precio" placeholder="Precio"><br>
        <textarea type="text" name="descripcion" id="descripcion" placeholder="Descripción"></textarea><br>
        <input type="text" name="fabricante" id="fabricante" placeholder="Fabricante"><br>
        <input type="number" min="0" step="any" name="cantidad" id="cantidad" placeholder="Cantidad"><br>
        <input type="text" name="fecha" id="fecha" placeholder="Fecha" onfocus="(this.type='date')" onblur="(this.type='text')"><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>