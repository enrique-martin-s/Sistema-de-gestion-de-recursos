<?php


require_once("models/timeslots.php");  // Modelos
require_once("view.php");
require_once("models/security.php"); // Security

class TimeslotsController
{
    private $db;             // Conexión con la base de datos
    private $timeslot, $autor;  // Modelos

    public function __construct()
    {
        $this->timeslot = new Timeslot();
    }


    public function showTimeslots()
    {
        $data["timeslotList"] = $this->timeslot->getAll();
        View::render("timeslot/all", $data);
        // if (Security::haySesion()) {
        //     $data["timeslotList"] = $this->timeslot->getAll();
        //     View::render("timeslot/all", $data);
        // } else {
        //     $data["error"] = "No tienes permiso para eso";
        //     View::render("usuario/login", $data);
        // }
    }

    // --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

    public function formAddTimeslot()
    {   
        View::render("timeslot/form");
        /* if (Security::haySesion()) {
            View::render("timeslot/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        } */
    }

    // --------------------------------- INSERTAR LIBROS ----------------------------------------

    public function insertTimeslot()
    {
        if(Security::isLogged()){
            $dayOfWeek = Security::limpiar($_REQUEST["dayOfWeek"]);
            $startTime = Security::limpiar($_REQUEST["startTime"]);
            $endTime = Security::limpiar($_REQUEST["endTime"]);
            $result = $this->timeslot->insert($dayOfWeek, $startTime, $endTime);
            header("Location: index.php?controller=TimeslotsController&action=showTimeslots");
        }else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }

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

    public function deleteTimeslot()
    {   
        $id = $_REQUEST["id"];
        $result = $this->timeslot->delete($id);
        $data["timeslotList"] = $this->timeslot->getAll();
        header("Location: index.php?controller=TimeslotsController&action=showTimeslots");
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

    public function updateTimeslot()
    {
        if (Security::isLogged()) {
            // Recuperamos los datos del timeslot a modificar
            $data["timeslot"] = $this->timeslot->get(Security::limpiar($_REQUEST["id"]));
            View::render("timeslot/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }

    // --------------------------------- MODIFICAR LIBROS ----------------------------------------

    public function modifyTimeslot()
    {   
        if (Security::isLogged()) {
            // Primero, recuperamos todos los datos del formulario
            $id = Security::limpiar($_REQUEST["id"]);
            $dayOfWeek = Security::limpiar($_REQUEST["dayOfWeek"]);
            $startTime = Security::limpiar($_REQUEST["startTime"]);
            $endTime = Security::limpiar($_REQUEST["endTime"]);
            $result = $this->timeslot->update($id, $dayOfWeek, $startTime, $endTime);
            header("Location: index.php?controller=TimeslotsController&action=showTimeslots");
        }else{
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }
}