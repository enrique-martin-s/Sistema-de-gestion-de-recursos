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
              <th>Día</th>
              <th>Hora de inicio</th>
              <th>Hora de fin</th>";
              if (Security::getType() == "admin") {
                echo "<th colspan='2'>Actions</th>";
                }
            "</tr>
          </thead>";
  $counter = 0;
  $day = "";
  foreach ($timeslotList as $fila) {
    if($day!=$fila->dayOfWeek){
      $counter=0;
      echo "<tr >";
      echo "<td name=".$fila->dayOfWeek." rowspan='1'>".$fila->dayOfWeek."</td>";
    }else{
      echo "<tr >";
      ?>
        <script>
          var row = document.getElementsByName("<?php echo $fila->dayOfWeek ?>");
          row[0].rowSpan = row[0].rowSpan + 1;
        </script>
      <?php

    }
    echo "<td>".$fila->startTime."</td>";
    echo "<td>".$fila->endTime."</td>";
    if (Security::getType() == "admin") {
      echo "<td><button onclick='modificar(".$fila->id.")'>Modificar</button></td>";
      echo "<td><button onclick='confirmarBorrado(".$fila->id.")'>Borrar</button></td>";
    }
    echo "</tr>";
    $day=$fila->dayOfWeek;
  }
  echo "</table>";

}
//echo "<p><a href='index.php?controller=timeslotsController&action=addAllTimeslots'>Añadir todos los timeslots</a></p>";
echo "<p><a href='index.php?controller=timeslotsController&action=formAddTimeslot'>Nuevo</a></p>";
?>
<script>
  function confirmarBorrado(id) {
  if (confirm("¿Estás seguro de que quieres borrar este recurso?")) {
    window.location.href = "index.php?controller=TimeslotsController&action=deleteTimeslot&id="+id;
  }
}
function modificar(id) {
  window.location.href = "index.php?controller=TimeslotsController&action=updateTimeslot&id="+id;
}
</script>
