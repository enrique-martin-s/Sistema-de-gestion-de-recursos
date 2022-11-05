<?php
    $realname = $_SESSION["realname"]??"Nuevo usuario";
    $type = $_SESSION["type"]??"sin registrar";
    echo "<div class='title'>";
    echo "<div class='title-left'>";
    echo "<h2>Gestor de recursos</h2>";
    echo "</div>";
    echo "<div class='title-right'>";
    echo "<h3>" . $realname . " (" .$type . ")</h3>";
    echo "<img src='/assets/images/profile-picture-placeholder.png' alt='profile-picture' style='width:50px ; border: 1px solid black;'>";
    echo "</div>";
    echo "</div>";
?>
<script>
    if (<?php echo json_encode($_SESSION["type"]) ?> == "admin") {
        document.getElementsByClassName("title")[0].style.backgroundColor = "var(--orange)";
    }
</script>
