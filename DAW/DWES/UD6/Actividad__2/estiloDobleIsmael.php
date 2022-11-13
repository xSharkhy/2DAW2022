<?php
/*
    Muestra dos botones en la parte superior para cambiar el tema de la página.
    El tema por defecto es el claro.
    Guarda la elección del usuario en una cookie.
*/

// Si no existe la cookie, se crea con el tema claro
if (!isset($_COOKIE['tema'])) {
    setcookie('tema', 'light', time() + 3600, $httponly = true);
    header('Location: estiloDobleIsmael.php');
}

/*
    Si existe la cookie, se comprueba si el valor es light o dark.
    Comprobamos el valor que nos llega por POST y en función de ello
    cambiamos el valor de la cookie.

    Si el valor que nos llega es desconocido, redirige a una página de error.
*/
if (isset($_POST['tema'])) {
    if ($_POST['tema'] == 'Tema Oscuro') {
        setcookie('tema', 'dark', time() + 3600, $httponly = true);
        header('Location: estiloDobleIsmael.php');
    } elseif ($_POST['tema'] == 'Tema Claro') {
        setcookie('tema', 'light', time() + 3600, $httponly = true);
        header('Location: estiloDobleIsmael.php');
    } else {
        header('Location: redirect.html');
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
    <link rel="stylesheet" href="css/<?= $_COOKIE['tema'] ?? 'light' ?>.css">
</head>

<body>
    <form action="#" method="post">
        <fieldset>
            <legend>Cambia el tema de la página!</legend>
            <input type="submit" name="tema" value="Tema Claro">
            <input type="submit" name="tema" value="Tema Oscuro">
        </fieldset>
    </form>
    <header>
        <h1>Ismael Morejón Blasco</h1>
        <p>
            Lorem fistrum pupita la caidita ahorarr. Está la cosa muy malar mamaar ahorarr pupita me cago en tus muelas se calle ustée condemor la caidita mamaar ese que llega condemor. Quietooor pecador se calle ustée por la gloria de mi madre la caidita te va a hasé pupitaa jarl a peich pecador. A gramenawer hasta luego Lucas llevame al sircoo diodenoo te voy a borrar el cerito ese pedazo de no puedor. A gramenawer condemor apetecan a wan fistro diodenoo condemor te va a hasé pupitaa jarl. Diodenoo llevame al sircoo a wan llevame al sircoo no te digo trigo por no llamarte Rodrigor al ataquerl hasta luego Lucas no puedor ese que llega pecador.
        </p>
        <p>
            Condemor llevame al sircoo al ataquerl diodeno benemeritaar caballo blanco caballo negroorl a peich amatomaa. Qué dise usteer qué dise usteer condemor no puedor pupita no te digo trigo por no llamarte Rodrigor se calle ustée ese que llega te voy a borrar el cerito a peich jarl. La caidita a peich torpedo condemor ahorarr pupita torpedo fistro llevame al sircoo. Tiene musho peligro va usté muy cargadoo tiene musho peligro ahorarr diodeno te va a hasé pupitaa. Quietooor me cago en tus muelas ahorarr no te digo trigo por no llamarte Rodrigor condemor. No te digo trigo por no llamarte Rodrigor hasta luego Lucas te voy a borrar el cerito quietooor tiene musho peligro jarl diodeno te voy a borrar el cerito no te digo trigo por no llamarte Rodrigor a peich te va a hasé pupitaa. De la pradera ahorarr hasta luego Lucas la caidita condemor tiene musho peligro a gramenawer ese que llega no puedor. Se calle ustée apetecan apetecan me cago en tus muelas ese hombree.
        </p>
        <p>
            Mamaar por la gloria de mi madre hasta luego Lucas no puedor de la pradera la caidita amatomaa por la gloria de mi madre al ataquerl. Ese que llega no te digo trigo por no llamarte Rodrigor amatomaa ese pedazo de diodenoo papaar papaar ese que llega te va a hasé pupitaa fistro. Por la gloria de mi madre mamaar no te digo trigo por no llamarte Rodrigor apetecan condemor a wan mamaar. Está la cosa muy malar ahorarr llevame al sircoo llevame al sircoo llevame al sircoo. Amatomaa ese hombree pecador ahorarr llevame al sircoo amatomaa se calle ustée te va a hasé pupitaa diodeno amatomaa. A wan a wan ese hombree no puedor ahorarr condemor me cago en tus muelas va usté muy cargadoo quietooor. A peich hasta luego Lucas ese pedazo de apetecan te voy a borrar el cerito benemeritaar ese pedazo de te voy a borrar el cerito diodeno condemor ese hombree. No te digo trigo por no llamarte Rodrigor a gramenawer condemor llevame al sircoo quietooor tiene musho peligro se calle ustée.
        </p>
    </header>
</body>

</html>