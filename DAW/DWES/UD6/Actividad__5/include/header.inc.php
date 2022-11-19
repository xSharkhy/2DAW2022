<header class="container header">
    <h2 id="headerh2"><a href="index.php">MerchaShop Ismael</a></h2>
    <nav class="topnav navs">
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="img/luffy.jpg" alt="Luffy" height="52px"></a>
        <a href="index.php">Inicio</a>
        <a href="ofertas.php">Ofertas</a>
        <?php
        if (isset($_SESSION['user'])) echo '<a href="carrito.php">Carrito<sub>' . (isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : '0') . '</sub></a>
                <a href="logout.php">Cerrar sesión</a>';
        elseif (isset($_SESSION['admin'])) echo '<a href="carrito.php">Carrito<sub>' . (isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : '0') . '</sub></a>
                <a href="usuarios.php">Usuarios</a>
                <a href="logout.php">Cerrar sesión</a>';
        ?>
    </nav>
</header>