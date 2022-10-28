<hr/>
<nav>
    Menú de navegación: 
    <?php
        if (Security::isLogged()) {
            echo "<a href='index.php?controller=ReservationController&action=showReservations'>Reservas</a>";
        }else
            echo "<a href='index.php'>Home</a>";
    
    if (Security::isLogged()) {
    echo " <a href='index.php?controller=ResourcesController&action=showResources'>Recursos</a>
    <a href='index.php?controller=TimeslotsController&action=showTimeslots'>Lista de horarios</a>";
    if (Security::getType() == "admin") {
        echo " <a href='index.php?controller=UserController&action=showUsers'>Usuarios</a>";
    }
    echo " <a href='index.php?controller=UserController&action=closeSession'>Cerrar sesión</a>";
        }
    ?>
</nav>
<hr/>