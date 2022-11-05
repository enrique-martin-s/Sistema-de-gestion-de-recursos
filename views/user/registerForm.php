<?php
if (isset($data["error"])) {
        echo "<div style='color: red'>".$data["error"]."</div>";
}

if (isset($data["user"])) {  
        echo "<h1>Modify user</h1>";
        $user = $data["user"];
    } else {
        echo "<h1>Register a new user</h1>";
        $user = false;
 }


// Sacamos los datos del usuario (si existe) a variables individuales para mostrarlo en los inputs del formulario.
// (Si no hay usuario, dejamos los campos en blanco y el formulario servirá para inserción).
$id = $user->id ?? "";
$userList = $data["userList"] ?? "";
if($user==false){
    $userArray = array();
    foreach ($userList as $key => $option) {
        $userArray[$key] = $option->username;
    }
}
$username = $user->username ?? "";
$realname = $user->realname ?? "";
?>
<div id="error" style='color: red'></div>
<?php

// Creamos el formulario con los campos de registro de usuario
echo "<form action = 'index.php' method = 'post'>
        <input type='hidden' name='id' value='".$id."'>";
if ($user!=false) {
echo    "Usuario:<input type='text' id='username' name='username' value='".$username."' readonly><br>
        Nombre mostrado:<input type='text' name='realname' value='".$realname."' required><br>
        Contraseña actual:<input type='password' id='prePass' name='prepassword' required><br>
        <input type='hidden' name='action' value='updateUser'>";
}else{
echo    "Usuario:<input type='text' id='username' name='username' value='".$username."' required><br>
        Nombre mostrado:<input type='text' name='realname' value='".$username."' required><br>
        <input type='hidden' name='action' value='processFormAddUser'>";
}
echo    " Password:<input id='pass' type='password' name='password' value='' required><br>
        Confirmar contraseña:<input id='confPass' type='password' name='confpassword' value='' required><br>
        <input type='hidden' name='controller' value='UserController'>";
echo "	<button type='button'  onclick='formCheck(".json_encode($user).",".json_encode($userList).")'> Enviar </button></form>";
echo "<p><a href='index.php'>Volver</a></p>";
?>
<script>

    

function formCheck(usuario, userList) {
    console.log(user)
    if(usuario){
        var user = usuario;
        var prePass = document.getElementById("prePass").value;
    }else{
        var user = null;
    }
    var username = document.getElementById("username").value;
    var pass = document.getElementById("pass").value;
    var confPass = document.getElementById("confPass").value;

    //search for user in userList
    var userFound = false;
        for (var i = 0; i < userList.length; i++) {
            if(userList[i].username == username){
                userFound = true;
                break;
            }
        }
    if(!userFound){
        if(pass != confPass) {
            document.getElementById("error").innerHTML = "Las contraseñas no coinciden";
            }else{
                if(user==null) {
                    document.forms[0].submit();
                }
                else{
                    if(prePass != user.password) {
                        document.getElementById("error").innerHTML = "La contraseña actual no es correcta";
                    }else{
                        if(pass == user.password) {
                            document.getElementById("error").innerHTML = "La nueva contraseña no puede ser igual a la actual";
                        }else{
                            document.forms[0].submit();
                        }
                    }
                }
            }
    }else{
        document.getElementById("error").innerHTML = "El usuario ya existe";
    }
}
</script>