<?php
// VISTA PARA LA LISTA DE LIBROS

// Recuperamos la lista de libros
$resourceList = $data["resourceList"];

// Si hay algún mensaje de feedback, lo mostramos
if (isset($data["info"])) {
  echo "<div style='color:blue'>".$data["info"]."</div>";
}

if (isset($data["error"])) {
  echo "<div style='color:red'>".$data["error"]."</div>";
}

echo "<form action='index.php'>
        <input type='hidden' name='action' value='buscarLibros'>
        <input type='text' name='textoBusqueda'>
        <input type='submit' value='Buscar'>
      </form><br>";

// Ahora, la tabla con los datos de los libros
if (count($resourceList) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  foreach ($resourceList as $fila) {
    echo "<tr>";
    echo "<td>" . $fila->name . "</td>";
    echo "<td>" . $fila->description . "</td>";
    echo "<td>" . $fila->location . "</td>";
    echo "<td>" . $fila->image . "</td>";
    echo "<td><a href='index.php?action=formularioModificarLibro&idLibro=" . $fila->idLibro . "'>Modificar</a></td>";
    echo "<td><a href='index.php?action=borrarLibro&idLibro=" . $fila->idLibro . "'>Borrar</a></td>";
    echo "</tr>";
  }
  echo "</table>";
}
echo "<p><a href='index.php?action=formularioInsertarLibros'>Nuevo</a></p>";