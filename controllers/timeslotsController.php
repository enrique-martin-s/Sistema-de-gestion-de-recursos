<?php


require_once("models/timeslots.php");  // Modelos
require_once("views/view.php");
require_once("models/security.php"); // Security

class TimeslotsController
{
    private $db;             // Conexión con la base de datos
    private $timeslot, $autor;  // Modelos

    public function __construct()
    {
        $this->timeslot = new Timeslot();
    }


    public function showTimeslots()
    {
        if(Security::isLogged()){
        $data["timeslotList"] = $this->timeslot->getAll();
        View::render("timeslot/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }

    // --------------------------------- FORMULARIO ALTA DE RECURSOS ----------------------------------------

    public function formAddTimeslot()
    {   
        if(Security::isLogged()){
        View::render("timeslot/form");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }

    // --------------------------------- INSERTAR RECURSOS ----------------------------------------

    public function insertTimeslot()
    {
        if(Security::isLogged()){
            $dayOfWeek = Security::limpiar($_REQUEST["dayOfWeek"]);
            $startTime = Security::limpiar($_REQUEST["startTime"]);
            $endTime = Security::limpiar($_REQUEST["endTime"]);
            $result = $this->timeslot->insert($dayOfWeek, $startTime, $endTime);
            header("Location: index.php?controller=TimeslotsController&action=showTimeslots");
        }else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }

    // --------------------------------- BORRAR RECURSOS ----------------------------------------

    public function deleteTimeslot()
    {   
        if(Security::isLogged()){
            $id = $_REQUEST["id"];
            $result = $this->timeslot->delete($id);
            $data["timeslotList"] = $this->timeslot->getAll();
            header("Location: index.php?controller=TimeslotsController&action=showTimeslots");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }
    

    // --------------------------------- FORMULARIO MODIFICAR RECURSOS ----------------------------------------

    public function updateTimeslot()
    {
        if (Security::isLogged()) {
            // Recuperamos los datos del timeslot a modificar
            $data["timeslot"] = $this->timeslot->get(Security::limpiar($_REQUEST["id"]));
            View::render("timeslot/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }

    // --------------------------------- MODIFICAR RECURSOS ----------------------------------------

    public function modifyTimeslot()
    {   
        if (Security::isLogged()) {
            // Primero, recuperamos todos los datos del formulario
            $id = Security::limpiar($_REQUEST["id"]);
            $dayOfWeek = Security::limpiar($_REQUEST["dayOfWeek"]);
            $startTime = Security::limpiar($_REQUEST["startTime"]);
            $endTime = Security::limpiar($_REQUEST["endTime"]);
            $result = $this->timeslot->update($id, $dayOfWeek, $startTime, $endTime);
            header("Location: index.php?controller=TimeslotsController&action=showTimeslots");
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }
    public function searchTimeslot()
    {
        if (Security::isLogged()) {
            $data["timeslotList"] = $this->timeslot->search(Security::limpiar($_REQUEST["textoBusqueda"]));
            View::render("timeslot/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }
    public function addAllTimeslots(){
            $dayArray = ["monday", "tuesday", "wednesday", "thursday", "friday"];
            $timeArray = ["08:05", "09:05", "10:05", "11:05", "11:35", "12:35", "13:35", "14:35"];
              for ($j = 0; $j < count($dayArray); $j++) {
                for ($k = 0; $k < (count($timeArray)-1); $k++) {
                    if($timeArray[$k] != "11:05")
                        $result = $this->timeslot->insert($dayArray[$j], $timeArray[$k], $timeArray[$k+1]);
                }
              }
        header("Location: index.php?controller=TimeslotsController&action=showTimeslots");
    }
}