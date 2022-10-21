<hr/>
<nav>
    Menú de navegación: 
    <?php
        if (Security::isLogged()) {
            echo "<a href='index.php?controller=ResourcesController&action=showResources'>Home</a>";
        }else
            echo "<a href='index.php'>Home</a>";
    
    if (Security::isLogged()) {
    echo " <a href='index.php?controller=ResourcesController&action=showResources'>Resources</a>
    <a href='index.php?controller=TImeslotsController&action=showTimeslots'> TimeSlots</a>
    <a href='index.php?controller=UserController&action=closeSession'>Cerrar sesión</a>";
        }
    ?>
</nav>
<hr/>