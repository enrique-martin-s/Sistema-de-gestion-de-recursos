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
            header("Location: index.php?controller=ResourcesController&action=showResources");
            Security::setLogged(true);
        } else {
            $data["error"] = "User o contraseña incorrectos";
            View::render("user/login", $data);
        }
    }

    public function formAddUser() {
        View::render("user/form");
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
            if ($result) { 
                header("Location: index.php?controller=UserController&action=formLogin");
                $data["info"] = "Usuario creado con éxito";
                View::render("user/login");
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
 
}