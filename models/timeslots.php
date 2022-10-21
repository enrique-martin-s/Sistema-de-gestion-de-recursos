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

    // Busca un texto en las tablas de libros y autores. Devuelve un array de objetos con todos los libros
    // que cumplen el criterio de búsqueda.
    public function search($textoBusqueda)
    {
        // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda
        $result = $this->db->dataQuery("SELECT * FROM Timeslots WHERE name LIKE '%$textoBusqueda%' OR description LIKE '%$textoBusqueda%'");
        return $result;
    }
}