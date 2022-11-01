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
        if(Security::isLogged()){
            if(Security::getType()=="admin"){
                $data["reservationList"] = $this->reservation->getAll();
            }else{
                $data["reservationList"] = $this->reservation->getUserReservations(Security::getUserId());
            }
        
        $reservationList = $data["reservationList"];
        if($reservationList != null){
            foreach ($reservationList as $key=>$reservation) {
                $data["reservations"][$key]["resource"] = $this->resource->get($reservation->idResource);
                $data["reservations"][$key]["timeslot"] = $this->timeslot->get($reservation->idTimeslot);
                $data["reservations"][$key]["user"] = $this->user->get($reservation->idUser);
            }
        }
        View::render("reservation/all", $data);
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }
    public function showDay(){
        if(Security::isLogged()){
            $idResource = Security::limpiar($_REQUEST["resource"]);
            $date = date("Y-m-d");
            $data["reservationList"] = $this->reservation->getResourceReservations($idResource, $date);
            $data["timeslots"] = $this->timeslot->getDayAllSlots(date('l', strtotime($date)));
            print_r($data["reservationList"]);
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }
    public function showCalendar(){
        if(Security::isLogged()){
            $data["resourceList"] = $this->resource->getAll();
            View::render("reservation/calendar", $data);
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }

    // --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

    public function formAddReservation()
    {   
        if(Security::isLogged()){
            $data["resourceList"] = $this->resource->getAll();
            View::render("reservation/form", $data);
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }

    // --------------------------------- INSERTAR LIBROS ----------------------------------------
    public function availableSlots(){
        $idResource = $_POST["resourceSelect"];
        $date = $_POST["datePicker"];
        $dayOfWeek = date("l", strtotime($date));
        $data["timeslotList"] = $this->timeslot->getAvailableDaySlots($idResource, $date, $dayOfWeek);
        $data["resource"] = $this->resource->get($idResource);
        $data["date"] = $date;
        View::render("reservation/available", $data);
    }
    public function insertReservation()
    {
        if(Security::isLogged()){
            $idResource = Security::limpiar($_REQUEST["idResource"]);
            $idTimeslot = Security::limpiar($_REQUEST["idTimeslot"]);
            $idUser = Security::limpiar($_SESSION["idUser"]);
            $date = Security::limpiar($_REQUEST["date"]);
            $remarks = Security::limpiar($_REQUEST["remarks"]);
            $result = $this->reservation->insert($idResource, $idTimeslot, $idUser, $date, $remarks);
            header("Location: index.php?controller=reservationController&action=showReservations");
        }else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }

    // --------------------------------- BORRAR LIBROS ----------------------------------------

    public function deleteReservation()
    {   
        if(Security::isLogged()){
            $id = Security::limpiar($_REQUEST["id"]);
            $result = $this->reservation->delete($id);
            $data["reservationList"] = $this->reservation->getAll();
            header("Location: index.php?controller=ReservationController&action=showReservations");
        }
    }
    

    // --------------------------------- FORMULARIO MODIFICAR LIBROS ----------------------------------------

    public function updateFormReservation()
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
            header("Location: index.php?controller=ReservationController&action=showReservations");
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }
}