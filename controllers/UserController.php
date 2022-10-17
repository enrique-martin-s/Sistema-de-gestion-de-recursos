<?php

include_once "models/user.php";
include_once "models/resources.php";

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
        } else {
            $data["error"] = "User o contraseña incorrectos";
            View::render("user/login", $data);
        }
    }

    // Cierra la sesión y nos lleva a la vista de login
    public function closeSession() {
        $this->user->closeSession();
        $data["info"] = "Sesión cerrada con éxito";
        View::render("user/login", $data);
    }
 
}