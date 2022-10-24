<?php

// CONTROLADOR DE LIBROS
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
        $data["resourceList"] = $this->resource->getAll();
        View::render("resource/all", $data);
        // if (Security::haySesion()) {
        //     $data["resourceList"] = $this->resource->getAll();
        //     View::render("resource/all", $data);
        // } else {
        //     $data["error"] = "No tienes permiso para eso";
        //     View::render("usuario/login", $data);
        // }
    }

    // --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

    public function formAddResource()
    {   
        View::render("resource/form");
        /* if (Security::haySesion()) {
            View::render("resource/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        } */
    }

    // --------------------------------- INSERTAR LIBROS ----------------------------------------

    public function insertResource()
    {

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

        /* if (Security::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $titulo = Security::limpiar($_REQUEST["titulo"]);
            $genero = Security::limpiar($_REQUEST["genero"]);
            $pais = Security::limpiar($_REQUEST["pais"]);
            $ano = Security::limpiar($_REQUEST["ano"]);
            $numPaginas = Security::limpiar($_REQUEST["numPaginas"]);
            $autores = Security::limpiar($_REQUEST["autor"]);

            $result = $this->libro->insert($titulo, $genero, $pais, $ano, $numPaginas);
            if ($result == 1) {
                // Si la inserción del libro ha funcionado, continuamos insertando los autores, pero
                // necesitamos conocer el id del libro que acabamos de insertar
                $idLibro = $this->libro->getMaxId();
                // Ya podemos insertar todos los autores junto con el libro en "escriben"
                $result = $this->libro->insertAutores($idLibro, $autores);
                if ($result > 0) {
                    $data["info"] = "Libro insertado con éxito";
                } else {
                    $data["error"] = "Error al insertar los autores del libro";
                }
            } else {
                // Si la inserción del libro ha fallado, mostramos mensaje de error
                $data["error"] = "Error al insertar el libro";
            }
            $data["listaLibros"] = $this->libro->getAll();
            View::render("libro/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        } */
    }

    // --------------------------------- BORRAR LIBROS ----------------------------------------

    public function deleteResource()
    {   
        $id = $_REQUEST["id"];
        $result = $this->resource->delete($id);
        $data["resourceList"] = $this->resource->getAll();
        header("Location: index.php?controller=ResourcesController&action=showResources");
        /* if (Security::haySesion()) {
            $id = $_REQUEST["id"];
            $result = $this->libro->delete($id);
            $data["listaLibros"] = $this->libro->getAll();
            View::render("libro/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        } */
    }
    

    // --------------------------------- FORMULARIO MODIFICAR LIBROS ----------------------------------------

    public function updateResource()
    {
        if (Security::isLogged()) {
            // Recuperamos los datos del resource a modificar
            $data["resource"] = $this->resource->get(Security::limpiar($_REQUEST["id"]));
            View::render("resource/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }

    // --------------------------------- MODIFICAR LIBROS ----------------------------------------

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
            View::render("usuario/login", $data);
        }
    }
}