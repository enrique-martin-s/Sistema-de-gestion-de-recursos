<?php


require_once("models/reservations.php");  // Modelos
require_once("models/resources.php");
require_once("models/timeslots.php");
require_once("models/user.php");
require_once("views/view.php");
require_once("models/security.php"); // Security

class ReservationController
{
    private $db;             // Conexión con la base de datos
    private $reservation, $timeslot, $resource;  // Modelos

    public function __construct()
    {
        $this->reservation = new Reservation();
        $this->timeslot = new Timeslot();
        $this->resource = new Resource();
        $this->user = new User();
        
    }


    public function showReservations()
    {
        $data["reservationList"] = $this->reservation->getAll();
        $reservationList = $data["reservationList"];
        if($reservationList != null){
            foreach ($reservationList as $key=>$reservation) {
                $data["reservations"][$key]["resource"] = $this->resource->get($reservation->idResource);
                $data["reservations"][$key]["timeslot"] = $this->timeslot->get($reservation->idTimeslot);
                $data["reservations"][$key]["user"] = $this->user->get($reservation->idUser);
            }
        }
        View::render("reservation/all", $data);
        // if (Security::haySesion()) {
        //     $data["reservationList"] = $this->reservation->getAll();
        //     View::render("reservation/all", $data);
        // } else {
        //     $data["error"] = "No tienes permiso para eso";
        //     View::render("usuario/login", $data);
        // }
    }

    // --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

    public function formAddReservation()
    {   
        View::render("reservation/form");
        /* if (Security::haySesion()) {
            View::render("reservation/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        } */
    }

    // --------------------------------- INSERTAR LIBROS ----------------------------------------

    public function insertReservation()
    {
        if(Security::isLogged()){
            $dayOfWeek = Security::limpiar($_REQUEST["dayOfWeek"]);
            $startTime = Security::limpiar($_REQUEST["startTime"]);
            $endTime = Security::limpiar($_REQUEST["endTime"]);
            $result = $this->reservation->insert($dayOfWeek, $startTime, $endTime);
            header("Location: index.php?controller=ReservationsController&action=showReservations");
        }else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }

        /* if (Security::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $titulo = Security::limpiar($_REQUEST["titulo"]);
            $genero = Security::limpiar($_REQUEST["genero"]);
            $pais = Security::limpiar($_REQUEST["pais"]);
            $ano = Security::limpiar($_REQUEST["ano"]);
            $numPaginas = Security::limpiar($_REQUEST["numPaginas"]);
            $autores = Security::limpiar($_REQUEST["autor"]);

            $result = $this->libro->insert($titulo, $genero, $pais, $ano, $numPaginas);
            if ($result == 1) {
                // Si la inserción del libro ha funcionado, continuamos insertando los autores, pero
                // necesitamos conocer el id del libro que acabamos de insertar
                $idLibro = $this->libro->getMaxId();
                // Ya podemos insertar todos los autores junto con el libro en "escriben"
                $result = $this->libro->insertAutores($idLibro, $autores);
                if ($result > 0) {
                    $data["info"] = "Libro insertado con éxito";
                } else {
                    $data["error"] = "Error al insertar los autores del libro";
                }
            } else {
                // Si la inserción del libro ha fallado, mostramos mensaje de error
                $data["error"] = "Error al insertar el libro";
            }
            $data["listaLibros"] = $this->libro->getAll();
            View::render("libro/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        } */
    }

    // --------------------------------- BORRAR LIBROS ----------------------------------------

    public function deleteReservation()
    {   
        $id = $_REQUEST["id"];
        $result = $this->reservation->delete($id);
        $data["reservationList"] = $this->reservation->getAll();
        header("Location: index.php?controller=ReservationsController&action=showReservations");
        /* if (Security::haySesion()) {
            $id = $_REQUEST["id"];
            $result = $this->libro->delete($id);
            $data["listaLibros"] = $this->libro->getAll();
            View::render("libro/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        } */
    }
    

    // --------------------------------- FORMULARIO MODIFICAR LIBROS ----------------------------------------

    public function updateReservation()
    {
        if (Security::isLogged()) {
            // Recuperamos los datos del reservation a modificar
            $data["reservation"] = $this->reservation->get(Security::limpiar($_REQUEST["id"]));
            View::render("reservation/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }

    // --------------------------------- MODIFICAR LIBROS ----------------------------------------

    public function modifyReservation()
    {   
        if (Security::isLogged()) {
            // Primero, recuperamos todos los datos del formulario
            $id = Security::limpiar($_REQUEST["id"]);
            $dayOfWeek = Security::limpiar($_REQUEST["dayOfWeek"]);
            $startTime = Security::limpiar($_REQUEST["startTime"]);
            $endTime = Security::limpiar($_REQUEST["endTime"]);
            $result = $this->reservation->update($id, $dayOfWeek, $startTime, $endTime);
            header("Location: index.php?controller=ReservationsController&action=showReservations");
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }
    public function addAllReservations(){
            $dayArray = ["monday", "tuesday", "wednesday", "thursday", "friday"];
            $timeArray = ["08:05", "09:05", "10:05", "11:05", "11:35", "12:35", "13:35", "14:35"];
              for ($j = 0; $j < count($dayArray); $j++) {
                for ($k = 0; $k < (count($timeArray)-1); $k++) {
                    $result = $this->reservation->insert($dayArray[$j], $timeArray[$k], $timeArray[$k+1]);
                }
              }
        header("Location: index.php?controller=ReservationsController&action=showReservations");
    }
}