<?php
include_once "./controllers/timeslotsController.php";
// Recuperamos la lista de libros
$userList = $data["userList"];

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
if (count($userList) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  echo "<thead>
            <tr>
              <th>Username</th>
              <th>Realname</th>
              <th>Type</th>
              <th colspan='2'>Actions</th>
            </tr>
          </thead>";
  foreach ($userList as $fila) {
    echo "<tr>";
    echo "<td>".$fila->username."</td>";
    echo "<td>".$fila->realname."</td>";
    echo "<td>".$fila->type."</td>";
    echo "<td><button onclick='modificar(".$fila->id.")'>Modificar</button></td>";
    echo "<td><button onclick='confirmarBorrado(".$fila->id.",".Security::getIdUsuario().")' >Borrar</button></td>";
    echo "</tr>";
  }
  echo "</table>";
}
//echo "<p><a href='index.php?controller=timeslotsController&action=addAllTimeslots'>Añadir todos los timeslots</a></p>";
echo "<p><a href='index.php?controller=timeslotsController&action=formAddTimeslot'>Nuevo</a></p>";
?>
<script>
  function confirmarBorrado(id , sessionId) {
  if(sessionId == id){
    alert("No puedes borrarte a ti mismo");
  }else{
    if (confirm("¿Estás seguro de que quieres borrar este usuario?")) {
      window.location.href = "index.php?controller=UserController&action=deleteUser&id="+id;
    }
  }
}
function modificar(id) {
  window.location.href = "index.php?controller=UserController&action=updateUser&id="+id;
}
</script>
