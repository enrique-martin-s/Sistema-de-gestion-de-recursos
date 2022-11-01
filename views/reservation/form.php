<?php
if (isset($data)) {
    extract($data);   
}
    $resourceList=$data["resourceList"];
    echo "<h1>Haz tu reserva</h1>";
?>

<form action = 'index.php' method = 'post'>
    <label for="resourceSelect">Elige un recurso y la fecha en la que lo quieres reservar</label>
    <select name="resourceSelect" id="resourceSelect" onchange="onSelectChange()">
    <option disabled selected>-----</option>
    <?php
    foreach ($resourceList as $resource) {
        echo "<option value='$resource->id'>$resource->name</option>";
    }
    ?>
    </select>    
    <?php echo "<input type='date' name='datePicker' id='datePicker' value=".date("Y-m-d")." min=".date("Y-m-d")."> <br>" ?>
<input type='hidden' name='controller' value='reservationController'>
<input type='hidden' name='action' value='availableSlots'>
<input type='submit' disabled></form>
<p><a href='index.php'>Volver</a></p>
<script>
    document.getElementById('datePicker').valueAsDate = new Date();
    function onSelectChange(){
        var resourceSelect = document.getElementById('resourceSelect');
        var submitButton = document.querySelector('input[type="submit"]');
        if(resourceSelect.value != ""){
            submitButton.disabled = false;
        }else{
            submitButton.disabled = true;
        }
    }
</script>
