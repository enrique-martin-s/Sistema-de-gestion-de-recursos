<?php

include_once "model.php";

class Timeslot extends Model
{


    public function __construct()
    {
        $this->table = "Timeslots";
        $this->idColumn = "id";
        parent::__construct();
    }


    public function getMaxId()
    {
        $result = $this->db->dataQuery("SELECT MAX(id) AS lastId FROM Timeslots");
        return $result[0]->lastId;
    }

    public function get($id)
    {
        $result = $this->db->dataQuery("SELECT * FROM Timeslots WHERE id = $id");
        return $result[0];
    }

    public function insert($dayOfWeek, $startTime, $endTime)
    {
        $result = $this->db->dataManipulation("INSERT INTO Timeslots (dayOfWeek, startTime, endTime) VALUES ('$dayOfWeek', '$startTime', '$endTime')");
        return $result;
    }

    // Inserta los autores de un recurso. Recibe el id del recurso y la lista de ids de los autores en forma de array.
    // Devuelve el número de autores insertados con éxito (0 en caso de fallo).
    // public function insertAutores($idLibro, $autores)
    // {
    //     $correctos = 0;
    //     foreach ($autores as $idAutor) {
    //         $correctos += $this->db->dataManipulation("INSERT INTO escriben(idLibro, idPersona) VALUES('$idLibro', '$idAutor')");
    //     }
    //     return $correctos;
    // }

    // Actualiza un Timeslot . Devuelve 1 si tiene éxito y 0 en caso de fallo.
    public function update($id, $dayOfWeek, $startTime, $endTime)
    {
        $result = $this->db->dataManipulation("UPDATE Timeslots SET dayOfWeek = '$dayOfWeek', startTime = '$startTime', endTime = '$endTime' WHERE id = $id");
        return $result;
    }
    public function delete($idTimeslot)
    {
        return $this->db->dataManipulation("DELETE FROM Timeslots WHERE id = '$idTimeslot'");

    }

    public function search($textoBusqueda)
    {
        $result = $this->db->dataQuery("SELECT * FROM Timeslots WHERE dayOfWeek LIKE '%$textoBusqueda%' OR startTime LIKE '%$textoBusqueda%' OR endTime LIKE '%$textoBusqueda%'");
        return $result;
    }
    public function getAvailableDaySlots($resourceId, $date, $dayOfWeek)
    {
        $result = $this->db->dataQuery("SELECT * FROM Timeslots WHERE dayOfWeek = '$dayOfWeek' AND id NOT IN (SELECT idTimeslot FROM Reservations WHERE idResource = '$resourceId' AND date = '$date')");
        return $result;
    }

    public function getDayAllSlots($dayOfWeek)
    {
        $result = $this->db->dataQuery("SELECT * FROM Timeslots WHERE dayOfWeek = '$dayOfWeek'");
        return $result;
    }

}