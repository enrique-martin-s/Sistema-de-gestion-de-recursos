<h1>Control de acceso</h1>

<?php
if (isset($data["error"])) {
    echo "<div style='color: red'>".$data["error"]."</div>";
}
if (isset($data["info"])) {
    echo "<div style='color: blue'>".$data["info"]."</div>";
}
?>

<form action="index.php" method="get">
    Email: <input type='text' name='username'><br/>
    Password: <input type='password' name='password'><br/>
    <input type='hidden' name='action' value='processFormLogin'>
    <input type='hidden' name='controller' value='UserController'>
    <button type='submit'>Send</button>
</form>
<p><a href='index.php?controller=UserController&action=formAddUser'>Nuevo usuario</a></p>