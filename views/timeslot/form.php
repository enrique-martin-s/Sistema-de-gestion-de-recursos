<?php
if (isset($data)) {
    extract($data);   
}

if (isset($timeslot)) {  
    echo "<h1>Modify timeslots</h1>";
} else {
    echo "<h1>Register a new timeslot</h1>";
}

// Sacamos los datos del timeslot (si existe) a variables individuales para mostrarlo en los inputs del formulario.
// (Si no hay timeslot, dejamos los campos en blanco y el formulario servirá para inserción).
$id = $timeslot->id ?? ""; 
$dayOfWeek = $timeslot->dayOfWeek ?? "";
$startTime = $timeslot->startTime ?? "00:00";
$endTime = $timeslot->endTime ?? "00:00";


// Creamos el formulario con los campos del timeslot
echo "<form action = 'index.php' method = 'post' enctype='multipart/form-data'>
        <input type='hidden' name='id' value='".$id."'>
        Day of the week:
        <select name='dayOfWeek'id='daySelect' required>
        <option value='monday'>Lunes</option>
        <option value='tuesday'>Martes</option>
        <option value='wednesday'>Miércoles</option>
        <option value='thursday'>Jueves</option>
        <option value='friday'>Viernes</option>
        <option value='saturday' >Sábado</option>
        <option value='sunday' >Domingo</option>
        <select/><br>
        Start time:<input type='time' name='startTime' value='".$startTime."'><br>
        End time:<input type='time' name='endTime' value='".$endTime."'><br>
        <input type='hidden' name='controller' value='timeslotsController'>";


if (isset($timeslot)) {
    echo "  <input type='hidden' name='action' value='modifyTimeslot'>";
} else {
    echo "  <input type='hidden' name='action' value='insertTimeslot'>";
}
echo "	<input type='submit'></form>";
echo "<p><a href='index.php?controller=TimeslotsController&action=showTimeslots'>Volver</a></p>";
?>
<script type="text/javascript">
    document.getElementById("daySelect").value = "<?php echo $dayOfWeek; ?>";
</script>