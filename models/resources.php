<?php

// MODELO DE RECURSOS

include_once "model.php";

class Resource extends Model
{

    // Constructor. Especifica el nombre de la tabla de la base de datos
    public function __construct()
    {
        $this->table = "Resources";
        $this->idColumn = "id";
        parent::__construct();
    }

    // Devuelve el último id asignado en la tabla de recursos
    public function getMaxId()
    {
        $result = $this->db->dataQuery("SELECT MAX(id) AS lastId FROM Resources");
        return $result[0]->lastId;
    }

    public function get($id)
    {
        $result = $this->db->dataQuery("SELECT * FROM Resources WHERE id = $id");
        return $result[0];
    }

    // Inserta un recurso. Devuelve 1 si tiene éxito o 0 si falla.
    public function insert($name, $description, $location, $image)
    {
        return $this->db->dataManipulation("INSERT INTO Resources (name,description,location,image) VALUES ('$name','$description', '$location', '$image')");
    }

    // Actualiza un resource . Devuelve 1 si tiene éxito y 0 en caso de fallo.
    public function update($idResource, $name, $description, $location, $image)
    {
        return $this->db->dataManipulation("UPDATE Resources SET name = '$name', description = '$description', location = '$location', image = '$image' WHERE id = $idResource");
    }
    public function delete($idResource)
    {
        return $this->db->dataManipulation("DELETE FROM Resources WHERE id = '$idResource'");

    }

    public function search($textoBusqueda)
    {
        // Buscamos los recursos de la biblioteca que coincidan con el texto de búsqueda
        $result = $this->db->dataQuery("SELECT * FROM Resources WHERE name LIKE '%$textoBusqueda%' OR description LIKE '%$textoBusqueda%'");
        return $result;
    }
}