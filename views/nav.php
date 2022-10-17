<hr/>
<nav>
    Menú de navegación: 
    <a href='index.php'>Home</a>
    <a href='index.php?controller=LibrosController&action=mostrarListaLibros'>To be</a>
    <a href='index.php?controller=AutoresController&action=mostrarListaAutores'>Done</a>
    <?php
        if (Security::isSession()) {
            echo "<a href='index.php?controller=UserController&action=closeSession'>Cerrar sesión</a>";
        }
    ?>
</nav>
<hr/>