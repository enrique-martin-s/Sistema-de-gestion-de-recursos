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

echo '<nav class="navbar navbar-light bg-light">';
echo "<form action='index.php' class='form-inline'>
        <input type='hidden' name='controller' value='userController'>
        <input type='hidden' name='action' value='searchUsers'>
        <input class='form-control mr-sm-2' type='search' placeholder='Busca' aria-label='Search' name='textoBusqueda'>
        <button class='btn btn-outline-success my-2 my-sm-0' type='submit'>Buscar</button>
      </form><br>";
      echo "<a href='index.php?controller=userController&action=formAddUser' class='btn btn-success'>Crear usuario</a>";
echo "      </nav>";

// Ahora, la tabla con los datos de los libros
if (count($userList) == 0) {
  echo "No hay datos";
} else {
  echo "<div class='row'>
  <table class='mx-auto' border ='1'>";
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
    echo "<td><button onclick='confirmarBorrado(".$fila->id.",".Security::getUserId().")' >Borrar</button></td>";
    echo "</tr>";
  }
  echo "</table></div>";
}

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
  window.location.href = "index.php?controller=UserController&action=updateUserForm&id="+id;
}
</script>
