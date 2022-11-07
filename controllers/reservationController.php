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
            // if(Security::getType()=="admin"){
            //     $data["reservationList"] = $this->reservation->getAllReservations();
            // }else{
            //     $data["reservationList"] = $this->reservation->getUserReservations(Security::getUserId());
            // }
            $data["reservationList"] = $this->reservation->getAllReservations();
        
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
            View::renderLogin("user/login", $data);
        }
    }
    public function showDay(){
        if(Security::isLogged()){
            $idResource = Security::limpiar($_REQUEST["resource"]);
            $date = date("Y-m-d");
            $data["reservationList"] = $this->reservation->getResourceReservations($idResource, $date);
            $data["timeslots"] = $this->timeslot->getDayAllSlots(date('l', strtotime($date)));
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }
    public function showCalendar(){
        if(Security::isLogged()){
            $data["resourceList"] = $this->resource->getAll();
            View::render("reservation/calendar", $data);
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }

    // --------------------------------- FORMULARIO NUEVAS RESERVAS ----------------------------------------

    public function formAddReservation()
    {   
        if(Security::isLogged()){
            $data["resourceList"] = $this->resource->getAll();
            View::render("reservation/form", $data);
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }
    // --------------------------------- FORMULARIO ACTUALIZAR RESERVA ----------------------------------------
    public function formUpdateReservation()
    {   
        if(Security::isLogged()){
            $data["reservation"] = $this->reservation->get(Security::limpiar($_REQUEST["id"]));
            $data["resource"] = $this->resource->get($data["reservation"][0]->idResource);
            $data["timeslot"] = $this->timeslot->get($data["reservation"][0]->idTimeslot);
            View::render("reservation/modifyForm", $data);
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }
    

    // --------------------------------- FORMULARIO SLOTS DISPONIBLES ----------------------------------------
    public function availableSlots(){
        $idResource = $_POST["resourceSelect"];
        $date = $_POST["datePicker"];
        $dayOfWeek = date("l", strtotime($date));
        $data["timeslotList"] = $this->timeslot->getAvailableDaySlots($idResource, $date, $dayOfWeek);
        $data["resource"] = $this->resource->get($idResource);
        $data["date"] = $date;
        if(isset($_POST["idReservation"])){
            $data["idReservation"] = $_POST["idReservation"];
        }
        View::render("reservation/available", $data);
    }

    // --------------------------------- AÑADIR RESERVAS ----------------------------------------
    public function insertReservation()
    {
        if(Security::isLogged()){
            $idResource = Security::limpiar($_REQUEST["idResource"]);
            $idTimeslot = Security::limpiar($_REQUEST["idTimeslot"]);
            $idUser = Security::limpiar($_SESSION["idUser"]);
            $date = Security::limpiar($_REQUEST["date"]);
            $remarks = Security::limpiar($_REQUEST["remarks"]);
            if($_REQUEST["repeatDate"]){
                $repeatDate = Security::limpiar($_REQUEST["repeatDate"]);
            }else{
                $repeatDate = null;
            }
            $this->reservation->insert($idResource, $idTimeslot, $idUser, $date, $remarks, $repeatDate);
            header("Location: index.php?controller=reservationController&action=showReservations");
        }else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }

    // --------------------------------- BORRAR RESERVAS ----------------------------------------

    public function deleteReservation()
    {   
        if(Security::isLogged()){
            $id = Security::limpiar($_REQUEST["id"]);
            $result = $this->reservation->delete($id);
            $data["reservationList"] = $this->reservation->getAll();
            header("Location: index.php?controller=ReservationController&action=showReservations");
        }
        else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }
    

    // --------------------------------- FORMULARIO MODIFICAR RESERVAS ----------------------------------------

    public function updateFormReservation()
    {
        if (Security::isLogged()) {
            // Recuperamos los datos del reservation a modificar
            $data["reservation"] = $this->reservation->get(Security::limpiar($_REQUEST["id"]));
            View::render("reservation/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }

    // --------------------------------- MODIFICAR RESERVAS ----------------------------------------

    public function modifyReservation()
    {   
        if (Security::isLogged()) {
            $id = Security::limpiar($_REQUEST["idReservation"]);
            $idResource = Security::limpiar($_REQUEST["idResource"]);
            $idTimeslot = Security::limpiar($_REQUEST["idTimeslot"]);
            $idUser = Security::limpiar($_SESSION["idUser"]);
            $date = Security::limpiar($_REQUEST["date"]);
            $remarks = Security::limpiar($_REQUEST["remarks"]);
            $result = $this->reservation->modify($id, $idResource, $idTimeslot, $idUser, $date, $remarks);
            header("Location: index.php?controller=reservationController&action=showReservations");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }
    // --------------------------------- BUSCADOR RESERVAS ----------------------------------------
    public function search(){
        if(Security::isLogged()){
            $data["reservationList"] = $this->reservation->search(Security::limpiar($_REQUEST["searchText"]));
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
            View::renderLogin("user/login", $data);
        }
    }
}