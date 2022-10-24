<?php
include_once "./controllers/timeslotsController.php";
// Recuperamos la lista de libros
$timeslotList = $data["timeslotList"];

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
if (count($timeslotList) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  echo "<thead>
            <tr>
              <th>Day</th>
              <th>Start time</th>
              <th>End time</th>
              <th colspan='2'>Actions</th>
            </tr>
          </thead>";
  foreach ($timeslotList as $fila) {
    echo "<tr>";
    echo "<td>" . $fila->dayOfWeek . "</td>";
    echo "<td>" . $fila->startTime . "</td>";
    echo "<td>" . $fila->endTime . "</td>";
    echo "<td><a href='index.php?controller=timeslotsController&action=updateTimeslot&id=" . $fila->id. "'>Modificar</a></td>";
    echo "<td><a href='index.php?controller=timeslotsController&action=deleteTimeslot&id=" . $fila->id . "'>Borrar</a></td>";
    echo "</tr>";
  }
  echo "</table>";
}
//echo "<p><a href='index.php?controller=timeslotsController&action=addAllTimeslots'>Añadir todos los timeslots</a></p>";
echo "<p><a href='index.php?controller=timeslotsController&action=formAddTimeslot'>Nuevo</a></p>";
?>
</script>
