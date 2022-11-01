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

echo "<form action='index.php' method = 'post'>
        <input type='hidden' name='controller' value='resourcesController'>
        <input type='hidden' name='action' value='searchResource'>
        <input type='text' name='textoBusqueda'>
        <input type='submit'>
      </form><br>";

// Ahora, la tabla con los datos de los libros
if (count($resourceList) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  echo "<thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Location</th>
              <th>Image</th>";
              if (Security::getType() == "admin") {
                echo "<th colspan='2'>Actions</th>";
                }
            "</tr>
          </thead>";
  foreach ($resourceList as $fila) {
    echo "<tr>";
    echo "<td>" . $fila->name . "</td>";
    echo "<td>" . $fila->description . "</td>";
    echo "<td>" . $fila->location . "</td>";
    echo "<td><img src='" . $fila->image . "' alt='imagen_recurso' width='100px' ></td>";
    if (Security::getType() == "admin") {
      echo "<td><button onclick='modificar(".$fila->id.")'>Modificar</button></td>";
      echo "<td><button onclick='confirmarBorrado(".$fila->id.")'>Borrar</button></td>";
    }
    echo "</tr>";
  }
  echo "</table>";
}
echo "<p><a href='index.php?controller=resourcesController&action=formAddResource'>Nuevo</a></p>";
?>
<script type="text/javascript">
function confirmarBorrado(id) {
  if (confirm("¿Estás seguro de que quieres borrar este recurso?")) {
    window.location.href = "index.php?controller=resourcesController&action=deleteResource&id="+id;
  }
}
function modificar(id) {
  window.location.href = "index.php?controller=resourcesController&action=updateResource&id="+id;
}
</script>