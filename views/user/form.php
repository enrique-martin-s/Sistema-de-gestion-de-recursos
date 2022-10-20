<?php


// Creamos el formulario con los campos de registro de usuario
echo "<form action = 'index.php' method = 'get'>
        Name:<input type='text' name='username' value=''><br>
        Password:<input type='text' name='password' value=''><br>
        Confirm password:<input type='text' name='confpassword' value=''><br>
        Real name:<input type='text' name='realname' value=''><br>
        <input type='hidden' name='controller' value='UserController'>
        <input type='hidden' name='action' value='processFormAddUser'>";

echo "	<input type='submit'></form>";
echo "<p><a href='index.php'>Volver</a></p>";