<?php


include_once "model.php";

class User extends Model
{

    // Constructor. Especifica el nombre de la tabla de la base de datos
    public function __construct()
    {
        $this->table = "Users";
        $this->idColumn = "id";
        parent::__construct();
    }

    // Comprueba si $username y $passwd corresponden a un usuario registrado. Si es así, inicia usa sesión creando
    // una variable de sesión y devuelve true. Si no, de vuelve false.
    public function login($username, $passwd) {
        $result = $this->db->dataQuery("SELECT * FROM Users WHERE username='$username' AND password='$passwd'");
        if (count($result) == 1) {
            Security::iniciarSesion($result[0]->id);
            return true;
        } else {
            return false;
        }
    }
    public function get($id)
    {
        $result = $this->db->dataQuery("SELECT * FROM Users WHERE id = $id");
        return $result[0];
    }

    // Cierra una sesión (destruye variables de sesión)
    public function cerrarSesion() {
        Security::closeSession();
    }

    public function addUser($username, $passwd, $realname) {
        $result = $this->db->dataManipulation("INSERT INTO Users (username, password, realname, type) VALUES ('$username', '$passwd', '$realname', 'user')");
        return $result;
    }

    public function updateUser($id, $username, $passwd, $realname) {
        $result = $this->db->dataManipulation("UPDATE Users SET username='$username', password='$passwd', realname='$realname' WHERE id=$id");
        return $result;
    }
    
    public function search($username) {
        $result = $this->db->dataQuery("SELECT * FROM Users WHERE username LIKE '%$username%' OR realname LIKE '%$username%' OR type LIKE '%$username%'");
        return $result;
    }
}