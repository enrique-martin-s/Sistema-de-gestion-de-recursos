<?php

// CAPA DE SEGURIDAD

// Esta clase puede mejorarse indefinidamente para construir
// aplicaciones más seguras. El resto de la aplicación no sufrirá ningún cambio.

// En esta implementación, usaremos variables de sesión para la autenticación de usuarios
// y limpieza de variables sencilla basada en una lista de palabras y caracteres prohibidos. 

class Security {

    // Abre una sesión y guarda el id del usuario
    public static function iniciarSesion($id) {
        $_SESSION["idUser"] = $id;
    }

    // Cierra una sesión y elimina el id del usuario
    public static function closeSession() {
        session_destroy();
    }

    // Devuelve el id del usuario que inició la sesión
    public static function getUserId() {
        if (isset($_SESSION["idUser"])) {
            return $_SESSION["idUser"];
        } else {
            return false;
        }
    }

    // Devuelve true si hay una sesión iniciada y false en caso contrario
    public static function isSession() {
        if (isset($_SESSION["idUser"])) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function setLogged($data){
        $_SESSION["valid"] = $data;
    }

    public static function isLogged() {
        if (isset($_SESSION["valid"])) {
            return true;
        }
        else {
            return false;
        }
    }
    public static function setType($data){
        $_SESSION["type"] = $data;
    }

    public static function getType() {
        if (isset($_SESSION["type"])) {
            return $_SESSION["type"];
        }
        else {
            return false;
        }
    }
    public static function setRealName($data){
        $_SESSION["realname"] = $data;
    }
    
    public static function getRealName() {
            return $_SESSION["realname"];
    }

    // Limpia un texto de caracteres o palabras sospechosas. Devuelve el texto limpio.
    public static function limpiar($text) {
        // Lista de palabras y caracteres prohibidos
        $blackList = ["<", ">", "insert", "update", "delete", "select", "*", "from"];
        foreach ($blackList as $blackWord) {
            $text = str_replace($blackWord, "", $text);
        }
        return $text;
    }
}