<?php
if (isset($data["error"])) {
        echo "<div style='color: red'>".$data["error"]."</div>";
}

if (isset($data)) {  
        echo "<h1>Modify user</h1>";
    } else {
        echo "<h1>Register a new user</h1>";
    }
$user = $data["user"];

// Sacamos los datos del usuario (si existe) a variables individuales para mostrarlo en los inputs del formulario.
// (Si no hay usuario, dejamos los campos en blanco y el formulario servirá para inserción).
$id = $user->id ?? "";
$username = $user->username ?? "";
$realname = $user->realname ?? "";


// Creamos el formulario con los campos de registro de usuario
echo "<form action = 'index.php' method = 'post'>
        <input type='hidden' name='id' value='".$id."'>
        User:<input type='text' name='username' value='".$username."'><br>
        Name shown:<input type='text' name='realname' value='".$realname."'><br>
        Password:<input id='pass' type='text' name='password' value=''><br>
        Confirm password:<input id='confPass' type='text' name='confpassword' value=''><br>
        <input type='hidden' name='controller' value='UserController'>";
        if (isset($user)) {
                echo "  <input type='hidden' name='action' value='updateUser'>";
            } else {
                echo "  <input type='hidden' name='action' value='processFormAddUser'>";
            } 
echo "	<input type='submit'></form>";
echo "<p><a href='index.php'>Volver</a></p>";