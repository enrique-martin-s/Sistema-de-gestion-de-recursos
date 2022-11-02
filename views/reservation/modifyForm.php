<?php
if (isset($data)) {
    extract($data);   
}
    $resource = $data["resource"]->name;
    $oldDate = $data["reservation"][0]->date;
    $timeslot = $data["timeslot"]->startTime." - ".$data["timeslot"]->endTime;
    echo "<h2>Cambia tu reserva</h2>";
    echo '<h4>Has reservado <u>'.$resource.'</u> el día <u>'.$oldDate.'</u> en la franja <u>'.$timeslot.'</u></h4>
          <h4>Selecciona la nueva fecha en que deseas reservarlo</h4>';
?>

<form action = 'index.php' method = 'post'>   
    <?php echo "<input type='date' onchange='dateChange()' name='datePicker' id='datePicker' value=".date("Y-m-d")." min=".date("Y-m-d")."> <br>" ?>
<input type='hidden' name='controller' value='reservationController'>
<input type='hidden' name='action' value='availableSlots'>
<input type='hidden' name='idReservation' value='<?php echo $data["reservation"][0]->id; ?>'>
<input type='hidden' name='resourceSelect' value=<?php echo $data["resource"]->id; ?>>
<input type='submit' disabled></form>
<p><a href='index.php'>Volver</a></p>
<script>
    function dateChange(){
        var datePicker = document.getElementById('datePicker');
        var submitButton = document.querySelector('input[type="submit"]');
        submitButton.disabled = false;
    }
</script>