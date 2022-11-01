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

echo "<form action='index.php'>
        <input type='hidden' name='action' value='buscarLibros'>
        <input type='text' name='textoBusqueda'>
        <input type='submit' value='Buscar'>
      </form><br>";
// Ahora, la tabla con los datos de los libros
if (count($reservations) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  echo "<thead>
            <tr>
              <th>Resource</th>
              <th>Image</th>
              <th>User</th>
              <th>Timeslot start</th>
              <th>Timeslot end</th>
              <th>Date</th>
              <th>Remarks</th>";
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
    echo "<td>" .$reservationList[$key]->date ."</td>";
    echo "<td>" .$reservationList[$key]->remarks ."</td>";
    if (Security::getType() == "admin" || $_SESSION["idUser"] == $reserve["user"]->id) {
      echo "<td><button onclick='modificar(" . $reservationList[$key]->id. ")'>Modificar</button></td>";
    echo "<td><button onclick='confirmarBorrado(" . $reservationList[$key]->id . ")'>Borrar</button></td>";
    }
    echo "</tr>";
  }
  echo "</table>";
}
echo "<p><a href='index.php?controller=reservationController&action=formAddReservation'>Nuevo</a></p>";
?>