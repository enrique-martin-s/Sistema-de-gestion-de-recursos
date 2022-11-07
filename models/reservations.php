<?php

include_once "model.php";

class Reservation extends Model
{


    public function __construct()
    {
        $this->table = "Reservations";
        $this->idColumn = "id";
        parent::__construct();
    }
    public function getReservationsInfo(){
        $result = $this->db->dataQuery("SELECT * FROM Reservations INNER JOIN Resources ON Reservations.idResource = Resources.id INNER JOIN Users ON Reservations.idUser = Users.id INNER JOIN TimeSlots ON Reservations.idTimeSlot = TimeSlots.id");
        return $result;
    }
    // recibe todas las reservas de la base de datos de un recurso en una fecha
    public function getResourceReservations($idResource, $date){
        $sql = "SELECT * FROM $this->table WHERE idResource = $idResource AND date = '$date'";
        $result = $this->db->dataQuery($sql);
        $reservations = array();
        foreach ($result as $reservation) {
            $reservations[] = $reservation;
        }
        return $reservations; 
    }
    // recibe todas las reservas de la base de datos ordenadas por fecha
    public function getAllReservations(){
        $sql = "SELECT * FROM $this->table ORDER BY date";
        $result = $this->db->dataQuery($sql);
        $reservations = array();
        foreach ($result as $reservation) {
            $reservations[] = $reservation;
        }
        return $reservations;
    }
    // recibe todas las reservas de la base de datos ordenadas por fecha de un usuario
    public function getUserReservations($idUser){
        $result = $this->db->dataQuery("SELECT * FROM Reservations  WHERE idUser = $idUser ORDER BY date" );
        return $result;
    }

    public function insert($idResource, $idTimeslot, $idUser, $date, $remarks, $repeatDate){
        //realiza la inserción en la base de datos tantas veces como se repita la fecha
        $sql = "INSERT INTO $this->table (idResource, idTimeslot, idUser, date, remarks) VALUES ($idResource, $idTimeslot, $idUser, '$date', '$remarks')";
        $result = $this->db->dataManipulation($sql);
        if($repeatDate != null){
            while($date<=$repeatDate){
                $date = date('Y-m-d', strtotime($date. ' + 7 days'));
                $sql = "INSERT INTO $this->table (idResource, idTimeslot, idUser, date, remarks) VALUES ($idResource, $idTimeslot, $idUser, '$date', '$remarks')";
                $result = $this->db->dataManipulation($sql);
            }
        }
        return $result;
    }

    // Actualiza un Reservation . Devuelve 1 si tiene éxito y 0 en caso de fallo.
    public function modify($id, $idResource, $idTimeslot, $idUser, $date, $remarks)
    {
        $result = $this->db->dataManipulation("UPDATE Reservations SET idResource = '$idResource', idTimeslot = '$idTimeslot', idUser = '$idUser', date = '$date', remarks = '$remarks' WHERE id = '$id'");
        return $result;
    }
    
    public function delete($idReservation)
    {
        return $this->db->dataManipulation("DELETE FROM Reservations WHERE id = '$idReservation'");

    }

    public function search($textoBusqueda)
    {
        $result = $this->db->dataQuery("SELECT * FROM Reservations INNER JOIN Resources ON Reservations.idResource = Resources.id INNER JOIN Timeslots ON Reservations.idTimeslot =  Timeslots.id  INNER JOIN Users ON Reservations.idUser = Users.id WHERE remarks LIKE '%$textoBusqueda%' OR date LIKE '%$textoBusqueda%' OR Resources.name LIKE '%$textoBusqueda%' OR Users.realname LIKE '%$textoBusqueda%' OR Timeslots.startTime LIKE '%$textoBusqueda%'");
        return $result;

    }
}