<?php

$reservationList = $data["reservationList"];
if(isset($data["reservations"])){
  $reservations = $data["reservations"];
}else{
  $reservations = [];
}

if (isset($data["info"])) {
  echo "<div style='color:blue'>".$data["info"]."</div>";
}

if (isset($data["error"])) {
  echo "<div style='color:red'>".$data["error"]."</div>";
}


usort($reservationList, function($a, $b) {
  return strtotime($a->date) - strtotime($b->date);
});

echo '<nav class="navbar navbar-light bg-light">';
echo "<form action='index.php' class='form-inline'>
        <input type='hidden' name='controller' value='reservationController'>
        <input type='hidden' name='action' value='search'>
        <input class='form-control mr-sm-2' type='search' placeholder='Busca' aria-label='Search' name='searchText'>
        <button class='btn btn-outline-success my-2 my-sm-0' type='submit'>Buscar</button>
      </form><br>";
      echo "<a href='index.php?controller=reservationController&action=formAddReservation' class='btn btn-primary'>Crear reserva</a>";
echo "      </nav>";
// Ahora, la tabla con los datos de los libros
if (count($reservations) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  echo "<thead>
            <tr>
              <th>Recurso</th>
              <th>Imagen</th>
              <th>Usuario</th>
              <th>Hora de inicio</th>
              <th>Hora de fin</th>
              <th>Fecha de reserva</th>
              <th>Anotaciones</th>";
              echo "<th colspan='2'>Actions</th>";
            echo "</tr>
          </thead>";
  foreach ($reservations as $key=>$reserve) {
    echo "<tr>";
    echo "<td>" . $reserve["resource"]->name . "</td>";
    echo "<td><img src='" . $reserve["resource"]->image . "' alt='imagen_recurso' width='100px' ></td>";
    echo "<td>" . $reserve["user"]->realname . "</td>";
    echo "<td>" .$reserve["timeslot"]->startTime ."</td>";
    echo "<td>" .$reserve["timeslot"]->endTime ."</td>";
    echo "<td>" .Utils::dayTranslator(strtolower(date('l', strtotime($reservationList[$key]->date)))) . ", " . date('d', strtotime($reservationList[$key]->date)) ." de ". Utils::monthTranslator(strtolower(date('F', strtotime($reservationList[$key]->date)))) ." ". date('Y', strtotime($reservationList[$key]->date)) ."</td>";
    echo "<td>" .$reservationList[$key]->remarks ."</td>";
    if ((Security::getType() == "admin" || $_SESSION["idUser"] == $reserve["user"]->id) && $reservationList[$key]->date > date("Y-m-d")) {
      echo "<td><button onclick='modificar(" . $reservationList[$key]->id. ")'>Modificar fecha</button></td>";
    }else{
      echo '<td><img src="/assets/images/bttf.jpeg" alt="No puedes" style="width:100px"></td>';
    }
    if (Security::getType() == "admin" || $_SESSION["idUser"] == $reserve["user"]->id) {
      echo "<td><button onclick='confirmarBorrado(" . $reservationList[$key]->id . ")'>Borrar</button></td>";
    }
    echo "</tr>";
  }
  echo "</table>";
}
?>
<script>
  function confirmarBorrado(id) {
  if (confirm("¿Estás seguro de que quieres borrar esta reserva?")) {
    window.location.href = "index.php?controller=reservationController&action=deleteReservation&id="+id;
  }
}
function modificar(id) {
  window.location.href = 'index.php?controller=reservationController&action=formUpdateReservation&id='+id;
}
</script>