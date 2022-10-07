<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imatges/luffy.jpg" type="image/x-icon">
    <title>Ismael Morejón</title>
</head>

<body id="topPage">
    <?php include_once("PHP/header.inc.php") ?>
    <div class="botonet">
        <script>
             function play() {
        var audio = document.getElementById("audio");
        audio.play();
      }
        </script>
        <input type="button" value="Choca esos 5 :)" onclick="play()"></button>
        <audio id="audio" src="recursos/bocina.mp3"></audio>
    </div>

    <?php include_once("PHP/footer.inc.php") ?>
</body>

</html>
