<div class="grid__container">
    <div class="header">
        <div class="revels-icon">
            <h2 id="headerh2"><a href="index.php"><img src="img/ICONO-NEGATIVO.svg" alt="Icono Revels">REVELS</a></h2>
        </div>
        <div class="search">
            <form action="results.php" method="post">
                <input type="text" name="search" id="search" class="input__box" placeholder="Buscar">
                <input type="submit" name="submitSearch" value="Buscar">
            </form>
        </div>
        <div class="new">
            <a href="new.php"><img src="img/NewPost.svg" alt="Nuevo Revels"> Nuevo REVELS</a>
        </div>
        <div class="account">
            <a href="account.php"><img src="img/Profile.svg" alt="Perfil"> Perfil</a>
        </div>
        <div class="logout">
            <a href="logout.php"><img src="img/Logout.svg" alt="Cerrar Sesión"> Cerrar sesión</a>
        </div>
    </div>
    <div class="aside">
        <h3>Following:</h3>
        <?php
        $following = $conexion->query('SELECT * FROM follows WHERE userid = ' . $_SESSION['id'] . ';');
        if ($following->rowCount() > 0) :
            while ($follow = $following->fetch()) :
                $user = $conexion->query('SELECT * FROM users WHERE id = ' . $follow['userfollowed'] . ';');
                $user = $user->fetch();
        ?>
                <a href="profile.php?id=<?= $user['id'] ?>"><?= $user['usuario'] ?></a>
            <?php
            endwhile;
        else :
            ?>
            <p>No sigues a nadie</p>
        <?php
        endif;
        ?>
    </div>