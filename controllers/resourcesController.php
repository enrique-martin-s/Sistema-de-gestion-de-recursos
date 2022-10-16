<?php

// CONTROLADOR DE LIBROS
include_once("models/resources.php");  // Modelos
include_once("view.php");
include_once("models/seguridad.php"); // Seguridad

class ResourcesController
{
    private $db;             // Conexión con la base de datos
    private $resource, $autor;  // Modelos

    public function __construct()
    {
        $this->resource = new Resource();
    }


    public function showResources()
    {
        $data["resourceList"] = $this->resource->getAll();
            View::render("resource/all", $data);
        // if (Seguridad::haySesion()) {
        //     $data["resourceList"] = $this->resource->getAll();
        //     View::render("resource/all", $data);
        // } else {
        //     $data["error"] = "No tienes permiso para eso";
        //     View::render("usuario/login", $data);
        // }
    }

    // --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

    public function formularioInsertarLibros()
    {
        if (Seguridad::haySesion()) {
            $data["todosLosAutores"] = $this->autor->getAll();
            $data["autoresLibro"] = array();  // Array vacío (el resource aún no tiene autores asignados)
            View::render("resource/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }

    // --------------------------------- INSERTAR LIBROS ----------------------------------------

    public function insertarLibro()
    {
        if (Seguridad::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $titulo = Seguridad::limpiar($_REQUEST["titulo"]);
            $genero = Seguridad::limpiar($_REQUEST["genero"]);
            $pais = Seguridad::limpiar($_REQUEST["pais"]);
            $ano = Seguridad::limpiar($_REQUEST["ano"]);
            $numPaginas = Seguridad::limpiar($_REQUEST["numPaginas"]);
            $autores = Seguridad::limpiar($_REQUEST["autor"]);

            $result = $this->resource->insert($titulo, $genero, $pais, $ano, $numPaginas);
            if ($result == 1) {

            } else {
                // Si la inserción del resource ha fallado, mostramos mensaje de error
                $data["error"] = "Error al insertar el resource";
            }
            $data["resourceList"] = $this->resource->getAll();
            View::render("resource/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }

    // --------------------------------- BORRAR LIBROS ----------------------------------------

    public function borrarLibro()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos el id del resource que hay que borrar
            $idLibro = Seguridad::limpiar($_REQUEST["idLibro"]);
            // Pedimos al modelo que intente borrar el resource
            $result = $this->resource->delete($idLibro);
            // Comprobamos si el borrado ha tenido éxito
            if ($result == 0) {
                $data["error"] = "Ha ocurrido un error al borrar el resource. Por favor, inténtelo de nuevo";
            } else {
                $data["info"] = "Libro borrado con éxito";
            }
            $data["resourceList"] = $this->resource->getAll();
            View::render("resource/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }

    // --------------------------------- FORMULARIO MODIFICAR LIBROS ----------------------------------------

    public function formularioModificarLibro()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos los datos del resource a modificar
            $data["resource"] = $this->resource->get(Seguridad::limpiar($_REQUEST["idLibro"])[0]);
            // Renderizamos la vista de inserción de resources, pero enviándole los datos del resource recuperado.
            // Esa vista necesitará la lista de todos los autores y, además, la lista
            // de los autores de este resource en concreto.
            $data["todosLosAutores"] = $this->autor->getAll();
            $data["autoresLibro"] = $this->autor->getAutores(Seguridad::limpiar($_REQUEST["idLibro"]));
            View::render("resource/form", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }

    // --------------------------------- MODIFICAR LIBROS ----------------------------------------

    public function modificarLibro()
    {
        if (Seguridad::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $idLibro = Seguridad::limpiar($_REQUEST["idLibro"]);
            $titulo = Seguridad::limpiar($_REQUEST["titulo"]);
            $genero = Seguridad::limpiar($_REQUEST["genero"]);
            $pais = Seguridad::limpiar($_REQUEST["pais"]);
            $ano = Seguridad::limpiar($_REQUEST["ano"]);
            $numPaginas = Seguridad::limpiar($_REQUEST["numPaginas"]);
            $autores = Seguridad::limpiar($_REQUEST["autor"]);

            // Pedimos al modelo que haga el update
            $result = $this->resource->update($idLibro, $titulo, $genero, $pais, $ano, $numPaginas);
            if ($result == 1) {
                $data["info"] = "Libro actualizado con éxito";
            } else {
                // Si la modificación del resource ha fallado, mostramos mensaje de error
                $data["error"] = "Ha ocurrido un error al modificar el resource. Por favor, inténtelo más tarde";
            }
            $data["resourceList"] = $this->resource->getAll();
            View::render("resource/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render("usuario/login", $data);
        }
    }
}