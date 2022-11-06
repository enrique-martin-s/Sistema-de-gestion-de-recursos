<?php

    $resource=$data["resource"];
    $timeslotList=$data["timeslotList"];
    $date=$data["date"];
    if(isset($data["idReservation"])){
        $idReservation=$data["idReservation"];
        echo '<h2>Modifica tu reserva. Nuevo dia'.$date.'</h2>';
    }else{
        $idReservation="";
        echo '<h2>Haz tu reserva</h2>';
    }

    
?>
<form  action="index.php" method="post"></form>
<label for="availableSlots"> Franjas horarias disponibles:</label>
<select name="availableSlots" id="slotPicker"></select><br>
<script>
    //crea uba checkbox que haga aparecer un selector de fecha para repetir la reserva
    //si se selecciona la checkbox, se crea un selector de fecha y cuando se elija una fecha se crea un boton para repetir la reserva
    //si se deselecciona la checkbox, se borra el selector de fecha y el boton de repetir reserva
    var timeslotList = <?php echo json_encode($timeslotList); ?>;
    if(timeslotList.length==0){
        document.getElementById("slotPicker").innerHTML="<option value=''>No hay franjas disponibles</option>";
    }
    var slotPicker = document.getElementById('slotPicker');
    var submitButton = document.querySelector('input[type="submit"]');
    for (var i = 0; i < timeslotList.length; i++) {
        var option = document.createElement("option");
        option.text = timeslotList[i].startTime+" - "+timeslotList[i].endTime;
        option.value = timeslotList[i].id;
        slotPicker.add(option);
    }
    if(slotPicker.length == 0){
        submitButton.disabled = true;
        print_r("slotPicker");
    }
</script>

<label for="remarks">Detalles:</label>
<input type="text" name="remarks" id="remarks">
<input type='submit' onclick="confirmReservation()">
<input type="checkbox" id="repeat" name="repeat" value="repeat">
<label for="repeat">Repetir reserva</label> <br>
<label id="labelRepeat" for="repeatDate" style="display:none">Hasta: </label>
<input type="date" id="repeatDate" name="repeatDate" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d", strtotime("+1 year")); ?>" style="display:none">
<script>
    var repeatCheckbox = document.getElementById("repeat");
    var repeatDate = document.getElementById("repeatDate");
    var repeatLabel = document.getElementById("labelRepeat");
    repeatCheckbox.addEventListener("change", function(){
        if(repeatCheckbox.checked){
            repeatDate.style.display = "inline";
            repeatLabel.style.display = "inline";
        }else{
            repeatDate.style.display = "none";
            repeatLabel.style.display = "none";
        }
    });
</script>
</form>
<p><a href='javascript:history.back()'>Volver</a></p>
<script>
    function confirmReservation() {
        var slotPicker = document.getElementById('slotPicker');
        var selectedSlot = slotPicker.options[slotPicker.selectedIndex].value;
        var date = <?php echo json_encode($date); ?>;
        var remarks = document.getElementById('remarks').value;
        var resource = <?php echo json_encode($resource); ?>;
        if (confirm("¿Estás seguro de que quieres reservar "+resource.name+" el "+date+" en la franja de "+slotPicker.options[slotPicker.selectedIndex].text+" ?")) {
            if(<?php echo json_encode($idReservation); ?> != ""){
                var idReservation = <?php echo json_encode($idReservation); ?>;
                url = "index.php?controller=reservationController&action=modifyReservation&idReservation="+idReservation+"&date="+date+"&slot="+selectedSlot+"&remarks="+remarks+"&idResource="+resource.id+"&idTimeslot="+selectedSlot;
            }else{
                var url = "index.php?controller=reservationController&action=insertReservation&idResource="+resource.id+"&idTimeslot="+selectedSlot+"&date="+date+"&remarks="+remarks;
            }
            if(repeatCheckbox.checked){
                var repeatDate = document.getElementById("repeatDate").value;
                url += "&repeatDate="+repeatDate;
            }
        window.location.href = url;
        }
    }

</script>
