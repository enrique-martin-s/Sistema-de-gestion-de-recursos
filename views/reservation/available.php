<?php

    $resource=$data["resource"];
    $timeslotList=$data["timeslotList"];
    $date=$data["date"];
    if(isset($data["idReservation"])){
        $idReservation=$data["idReservation"];
    }

    
?>
<form  action="index.php" method="post"></form>
<label for="availableSlots"> Franjas horarias disponibles:</label>
<select name="availableSlots" id="slotPicker"></select><br>
<script>
    var timeslotList = <?php echo json_encode($timeslotList); ?>;
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
    }
</script>
<label for="remarks">Detalles:</label>
<input type="text" name="remarks" id="remarks">
<input type='submit' onclick="confirmReservation()">
</form>
<script>
    function confirmReservation() {
        var slotPicker = document.getElementById('slotPicker');
        var selectedSlot = slotPicker.options[slotPicker.selectedIndex].value;
        var date = <?php echo json_encode($date); ?>;
        var remarks = document.getElementById('remarks').value;
        var resource = <?php echo json_encode($resource); ?>;
        if (confirm("¿Estás seguro de que quieres reservar "+resource.name+" el "+date+" en la franja de "+slotPicker.options[slotPicker.selectedIndex].text+" ?")) {
            if(<?php echo isset($idReservation); ?>){
                var idReservation = <?php echo json_encode($idReservation); ?>;
                url = "index.php?controller=reservationController&action=modifyReservation&idReservation="+idReservation+"&date="+date+"&slot="+selectedSlot+"&remarks="+remarks+"&idResource="+resource.id+"&idTimeslot="+selectedSlot;
            }else{
                var url = "index.php?controller=reservationController&action=insertReservation&idResource="+resource.id+"&idTimeslot="+selectedSlot+"&date="+date+"&remarks="+remarks;
            }
        window.location.href = url;
        }
    }

</script>
