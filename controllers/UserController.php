<?php

require_once "models/user.php";
require_once "models/resources.php";

class UserController {

    private $user;

    public function __construct() {
        $this->user = new User();
    }

    // Muestra el formulario de login
    public function formLogin() {
        View::render("user/login");
    }

    // Comprueba los datos de login. Si son correctos, el modelo iniciará la sesión y
    // desde aquí se redirige a otra vista. Si no, nos devuelve al formulario de login.
    public function processFormLogin() {
        $name = Security::limpiar($_REQUEST["username"]);
        $passwd = Security::limpiar($_REQUEST["password"]);
        $result = $this->user->login($name, $passwd);
         if ($result) {
            Security::setLogged(true);
            $userInfo = $this->user->get($_SESSION["idUser"]);
            Security::setType($userInfo->type);
            header("Location: index.php?controller=ReservationController&action=showReservations");
        } else {
            $data["error"] = "User o contraseña incorrectos";
            View::render("user/login", $data);
        }
    }

    public function formAddUser() {
        View::render("user/registerForm");
    }
    public function processFormAddUser() {
        $name = Security::limpiar($_REQUEST["username"]);
        $passwd = Security::limpiar($_REQUEST["password"]);
        $confpasswd = Security::limpiar($_REQUEST["confpassword"]);
        $realname = Security::limpiar($_REQUEST["realname"]);
        
        if($passwd!=$confpasswd){
            $data["error"] = "Las contraseñas no coinciden";
            View::render("user/form", $data);
        }else{
            $result = $this->user->addUser($name, $passwd, $realname);
            if ($result) { // Si se ha insertado correctamente
                $data["info"] = "Usuario creado con éxito";
                if(Security::isLogged()){
                    $this->showUsers();
                }else{
                    View::render("user/login");
                }
            } else {
                $data["error"] = "Fallo al crear usuario";
                View::render("user/login");
            }
        }
    }


    // Cierra la sesión y nos lleva a la vista de login
    public function closeSession() {
        Security::setLogged(false);
        Security::closeSession();
        $data["info"] = "Sesión cerrada con éxito";
        header("Location: index.php");
        View::render("user/login", $data);

    }
    public function showUsers() {
        if(Security::isLogged() && Security::getType() == "admin"){
        $data["userList"] = $this->user->getAll();
        View::render("user/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }
    public function searchUsers(){
        if(Security::isLogged() && Security::getType() == "admin"){
        $data["userList"] = $this->user->search($_POST["textoBusqueda"]);
        View::render("user/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }

    public function deleteUser()
    {   
        if(Security::isLogged() && Security::getType() == "admin"){
        $id = $_REQUEST["id"];
        $result = $this->user->delete($id);
        $data["userList"] = $this->user->getAll();
        header("Location: index.php?controller=UserController&action=showUsers");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }
    public function updateUserForm() {
        if(Security::isLogged() && Security::getType() == "admin"){
        $id = $_REQUEST["id"];
        $data["user"] = $this->user->get($id);
        View::render("user/registerForm", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }

    public function updateUser() {
        if(Security::isLogged() && Security::getType() == "admin"){
        $id = $_REQUEST["id"];
        $name = Security::limpiar($_REQUEST["username"]);
        $passwd = Security::limpiar($_REQUEST["password"]);
        $confpasswd = Security::limpiar($_REQUEST["confpassword"]);
        $realname = Security::limpiar($_REQUEST["realname"]);
        if($passwd!=$confpasswd){
            $data["error"] = "Las contraseñas no coinciden";
            $data["user"] = $this->user->get($id);
            View::render("user/registerForm", $data);
        }else{
            $result = $this->user->updateUser($id, $name, $passwd, $realname);
            if ($result) { // Si se ha insertado correctamente
                $data["info"] = "Usuario actualizado con éxito";
                $data["userList"] = $this->user->getAll();
                View::render("user/all", $data);
            } else {
                $data["error"] = "Fallo al actualizar usuario";
                View::render("user/form", $data);
            }
        }
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("user/login", $data);
        }
    }
 
}