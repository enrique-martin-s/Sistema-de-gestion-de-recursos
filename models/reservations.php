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
    public function getResourceReservations($idResource, $date){
        $sql = "SELECT * FROM $this->table WHERE idResource = $idResource AND date = '$date'";
        $result = $this->db->dataQuery($sql);
        $reservations = array();
        foreach ($result as $reservation) {
            $reservations[] = $reservation;
        }
        return $reservations; 
    }

    public function getUserReservations($idUser){
        $result = $this->db->dataQuery("SELECT * FROM Reservations WHERE idUser = $idUser");
        return $result;
    }

    public function insert($idResource, $idTimeslot, $idUser, $date, $remarks)
    {
        $result = $this->db->dataManipulation("INSERT INTO Reservations (idResource, idTimeslot, idUser, date, remarks) VALUES ('$idResource', '$idTimeslot', '$idUser', '$date', '$remarks')");
        return $result;
    }

    // Inserta los autores de un libro. Recibe el id del libro y la lista de ids de los autores en forma de array.
    // Devuelve el número de autores insertados con éxito (0 en caso de fallo).
    // public function insertAutores($idLibro, $autores)
    // {
    //     $correctos = 0;
    //     foreach ($autores as $idAutor) {
    //         $correctos += $this->db->dataManipulation("INSERT INTO escriben(idLibro, idPersona) VALUES('$idLibro', '$idAutor')");
    //     }
    //     return $correctos;
    // }

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
        $result = $this->db->dataQuery("SELECT * FROM Reservations INNER JOIN Resources ON Reservations.idResource = Resources.id INNER JOIN Users ON Reservations.idUser = Users.id WHERE remarks LIKE '%$textoBusqueda%' OR date LIKE '%$textoBusqueda%' OR Resources.name LIKE '%$textoBusqueda%' OR Users.username LIKE '%$textoBusqueda%'");
        return $result;

    }
}