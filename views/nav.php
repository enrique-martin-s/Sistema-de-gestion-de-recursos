<hr/>
<nav>
    Menú de navegación: 
    <?php
        if (Security::isLogged()) {
            echo "<a href='index.php?controller=ResourcesController&action=showResources'>Home</a>";
        }else
            echo "<a href='index.php'>Home</a>";
    ?>
    
    <a href='index.php?controller=LibrosController&action=mostrarListaLibros'>To be</a>
    <a href='index.php?controller=AutoresController&action=mostrarListaAutores'>Done</a>
    <?php
        if (Security::isLogged()) {
            echo "<a href='index.php?controller=UserController&action=closeSession'>Cerrar sesión</a>";
        }
    ?>
</nav>
<hr/>