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
        View::renderlogin("user/login");
    }

    // Comprueba los datos de login. Si son correctos, el modelo iniciará la sesión y
    // desde aquí se redirige a otra vista. Si no, nos devuelve al formulario de login.
    public function processFormLogin() {
        if(isset($_REQUEST["username"])){
        $name = Security::limpiar($_REQUEST["username"]);
        $passwd = Security::limpiar($_REQUEST["password"]);
        }else{
            $name = "";
            $passwd = "";
        }
        $passwd = Security::toMd5($passwd);
        $result = $this->user->login($name, $passwd);
         if ($result) {
            Security::setLogged(true);
            $userInfo = $this->user->get($_SESSION["idUser"]);
            Security::setType($userInfo->type);
            Security::setRealName($userInfo->realname);
            header("Location: index.php?controller=ReservationController&action=showReservations");
        } else {
            $data["error"] = "Usuario o contraseña incorrectos";
            View::renderLogin("user/login", $data); 
        }
    }

    public function formAddUser() {
        $data["userList"]= $this->user->getAll();
        View::render("user/registerForm", $data);
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
            $passwd=Security::toMd5($passwd);
            $result = $this->user->addUser($name, $passwd, $realname);
            if ($result) { // Si se ha insertado correctamente
                $data["info"] = "Usuario creado con éxito";
                if(Security::isLogged()){
                    $this->showUsers();
                }else{
                    View::renderLogin("user/login", $data);
                }
            } else {
                $data["error"] = "Fallo al crear usuario";
                View::renderLogin("user/login");
                print_r($name);
            }
        }
    }


    // Cierra la sesión y nos lleva a la vista de login
    public function closeSession() {
        Security::setLogged(false);
        Security::closeSession();
        $data["info"] = "Sesión cerrada con éxito";
        header("Location: index.php");
        View::renderLogin("user/login", $data);

    }
    public function showUsers() {
        if(Security::isLogged() && Security::getType() == "admin"){
        $data["userList"] = $this->user->getAll();
        View::render("user/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }
    public function searchUsers(){
        if(Security::isLogged() && Security::getType() == "admin"){
        $data["userList"] = $this->user->search($_REQUEST["textoBusqueda"]);
        View::render("user/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
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
            View::renderLogin("user/login", $data);
        }
    }
    public function updateUserForm() {
        if(Security::isLogged() && Security::getType() == "admin"){
        $id = $_REQUEST["id"];
        $data["user"] = $this->user->get($id);
        View::render("user/registerForm", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }

    public function updateUser() {
        if(Security::isLogged() && Security::getType() == "admin"){
        $id = $_REQUEST["id"];
        $name = Security::limpiar($_REQUEST["username"]);
        $passwd = Security::toMd5(Security::limpiar($_REQUEST["password"]));
        $realname = Security::limpiar($_REQUEST["realname"]);
        $prepass = Security::toMd5(Security::limpiar($_REQUEST["prepassword"]));
        $data["user"] = $this->user->get($id);
        // print_r($user->password);
        // print("<br>");
        // print_r($passwd);
        if($data["user"]->password != $prepass){
            $data["error"] = "La contraseña anterior no coincide";
            View::render("user/registerForm", $data);
        }else{
            $result = $this->user->updateUser($id, $name, $passwd, $realname);;
            if ($result) { // Si se ha insertado correctamente
                $data["info"] = "Usuario actualizado con éxito";
                $data["userList"] = $this->user->getAll();
                View::render("user/all", $data);
            } else {
                $data["user"] = $this->user->get($id);
                $data["error"] = "Fallo al actualizar usuario (¿Has cambiado los datos?)";
                View::render("user/registerForm", $data);
            }
        }
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }
    
}