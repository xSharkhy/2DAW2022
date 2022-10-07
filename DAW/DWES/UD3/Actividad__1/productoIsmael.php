<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
</head>

<body>
    <form action="datosproductoIsmael.php" method="GET">
        <input type="text" name="codigo" id="codigo" placeholder="Código"><br>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre"><br>
        <input type="text" name="precio" id="precio" placeholder="Precio"><br>
        <textarea type="text" name="descripcion" id="descripcion" placeholder="Descripción"></textarea><br>
        <input type="text" name="fabricante" id="fabricante" placeholder="Fabricante"><br>
        <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad"><br>
        <input type="text" name="fecha" id="fecha" placeholder="Fecha" onfocus="(this.type='date')" onblur="(this.type='text')"><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>