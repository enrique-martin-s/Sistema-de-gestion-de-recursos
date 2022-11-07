<?php

// CONTROLADOR DE RECURSOS
require_once("models/resources.php");  // Modelos
require_once("views/view.php");
require_once("models/security.php"); // Security

class ResourcesController
{
    private $db;             // Conexión con la base de datos
    private $resource;  // Modelos

    public function __construct()
    {
        $this->resource = new Resource();
    }


    public function showResources()
    {
        if(Security::isLogged()){
        $data["resourceList"] = $this->resource->getAll();
        View::render("resource/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }

    public function searchResource(){
        if(Security::isLogged()){
        $data["resourceList"] = $this->resource->search($_REQUEST["textoBusqueda"]);
        View::render("resource/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }

    // --------------------------------- FORMULARIO ALTA DE RECURSOS ----------------------------------------

    public function formAddResource()
    {   
        if(Security::isLogged()){
            View::render("resource/form");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }

    // --------------------------------- INSERTAR RECURSOS ----------------------------------------

    public function insertResource()
    {
        if(Security::isLogged()){
        $origen = $_FILES['subir_archivo']['tmp_name'];
        $destino = 'assets/images/'.basename($_FILES['subir_archivo']['name']);
        if (move_uploaded_file($origen,
            $destino)) {
                $name = $_REQUEST["name"];
                $description = $_REQUEST["description"];
                $location = $_REQUEST["location"];
                $image = $destino;
                $result = $this->resource->insert($name, $description, $location, $image);        
            } else {
                echo "Error al subir el archivo";
            };
        header("Location: index.php?controller=ResourcesController&action=showResources");

    } else {
        $data["error"] = "No tienes permiso para eso";
        View::renderLogin("user/login", $data);
    }
    }

    // --------------------------------- BORRAR RECURSOS ----------------------------------------

    public function deleteResource()
    {   
        if(Security::isLogged()){
            $id = $_REQUEST["id"];
            $result = $this->resource->delete($id);
            $data["resourceList"] = $this->resource->getAll();
            header("Location: index.php?controller=ResourcesController&action=showResources");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login", $data);
        }
    }
    

    // --------------------------------- FORMULARIO MODIFICAR RECURSOS ----------------------------------------

    public function updateResource()
    {
        if (Security::isLogged()) {
            // Recuperamos los datos del resource a modificar
            $data["resource"] = $this->resource->get(Security::limpiar($_REQUEST["id"]));
            View::render("resource/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }

    // --------------------------------- MODIFICAR RECURSOS ----------------------------------------

    public function modifyResource()
    {   
        if (Security::isLogged()) {
            // Primero, recuperamos todos los datos del formulario
            $origen = $_FILES['subir_archivo']['tmp_name'];
            if($origen != null){
                $destino = 'assets/images/'.basename($_FILES['subir_archivo']['name']);
                if (move_uploaded_file($origen,
                    $destino)) {
                        $id = $_REQUEST["id"];
                        $name = $_REQUEST["name"];
                        $description = $_REQUEST["description"];
                        $location = $_REQUEST["location"];
                        $image = $destino;
                        $result = $this->resource->update($id, $name, $description, $location, $image);        
                    } else {
                        echo "Error al subir el archivo";
                    };
            } else {
                $id = $_REQUEST["id"];
                $name = $_REQUEST["name"];
                $description = $_REQUEST["description"];
                $location = $_REQUEST["location"];
                $image = $_REQUEST["image"];
                echo $image;
                $result = $this->resource->update($id, $name, $description, $location, $image);        
            }
            header("Location: index.php?controller=ResourcesController&action=showResources");
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::renderLogin("user/login");
        }
    }
}