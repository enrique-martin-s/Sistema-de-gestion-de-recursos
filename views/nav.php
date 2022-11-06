<nav class="navbar navbar-expand-lg navbar-light bg-light navborder">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <?php
        if (Security::isLogged()) {
            if(Security::getType()=="admin"){
                echo '<li class="nav-item active">
                <a class="nav-link" href="index.php?controller=ReservationController&action=showReservations">Reservas</a>
                </li>';
            }else{
                echo '<li class="nav-item">
                <a class="nav-link" href="index.php?controller=ReservationController&action=showReservations">Mis reservas</a>
                </li>'; 
                //echo '<a href='index.php?controller=ReservationController&action=showCalendar'>Calendario</a> ';  a hacer en un futuro;
            }
        }else{
            echo '<li class="nav-item">
            <a href="index.php">Home</a style="backgroundColor:var(--light-green)">
            </li>';
        }
    
    if (Security::isLogged() && Security::getType()=="admin") {
        echo ' <li class="nav-item">
        <a class="nav-link" href="index.php?controller=ResourcesController&action=showResources">Recursos</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="index.php?controller=TimeslotsController&action=showTimeslots">Lista de horarios</a>
        </li>';
        echo ' <li class="nav-item">
        <a class="nav-link" href="index.php?controller=UserController&action=showUsers">Usuarios</a>
        </li>';
    }
    if (Security::isLogged()) {
    echo ' <li class="nav-item">
    <a class="nav-link" href="index.php?controller=UserController&action=closeSession">Cerrar sesión</a>
    </li>';
    }  
    ?>
    </ul>
    </div>
</nav>