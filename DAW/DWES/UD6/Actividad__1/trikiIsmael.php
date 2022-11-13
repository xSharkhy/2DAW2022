<?php
/*
    Informa del uso de cookies en la web, el usuario deberá aceptarlas para
    poder navegar por la web. Al hacerlo, se creará una cookie que expirará
    en 60 segundos para guardar que se ha aceptado el uso de cookies.

    Mientras la cookie esté activa, no volverá a aparecer el aviso de cookies.
    Si se borra la cookie, volverá a aparecer el aviso de cookies.
*/
if (isset($_POST['aceptarCookies'])) {
    // Si se ha pulsado el botón de aceptar cookies, se crea la cookie
    setcookie('aceptarCookies', '1', time() + 60, $httponly = true);
    $mostrarAvisoCookies = false;
    header('Location: trikiIsmael.php');
}

$mostrarAvisoCookies = isset($_COOKIE['aceptarCookies']) ? false : true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ismael Morejón</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-image: url(https://wallpapercave.com/wp/dudm3tn.jpg);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 1.2rem;
            margin: 0;
            padding: 0;
        }

        #avisoCookies {
            display: flex;
            flex-direction: column;
            border: 5px double #5a2c22;
            background-color: #efe2b2;
            color: #5a2c22;
            margin: 5rem auto;
        }

        #avisoCookies p {
            margin: 0;
            padding: 0.5rem;
        }

        #avisoCookies button {
            background-color: #5a2c22;
            border: none;
            color: #efe2b2;
            cursor: pointer;
            font-size: 1rem;
            margin: 0.5rem;
            padding: 0.5rem;
        }

        #avisoCookies button:hover {
            background-color: #84563c;
        }
    </style>
</head>

<body>
    <?php
    if ($mostrarAvisoCookies) {
        // Si se debe mostrar el aviso de cookies, se muestra
        echo '<div id="avisoCookies">
                <p>Esta web utiliza cookies para mejorar la experiencia de usuario.</p>
                <form action="#" method="post">
                    <input type="submit" name="aceptarCookies" value="Aceptar cookies">
                </form>
            </div>';
    }
    ?>
</body>

</html>