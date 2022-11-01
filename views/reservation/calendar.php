<?php
$resourceList=$data["resourceList"];
//crea un selector con todos los recursos y que al elegir lance la funcion onResourceChange
echo "<select id='resource' onchange='onResourceChange()'>";
echo "<option disabled selected>-----</option>";
foreach($resourceList as $resource){
    echo "<option value='".$resource->id."'>".$resource->name."</option>";
}
echo "</select>";
echo "<select id='selectCalendario' onchange='onCalendarSelectChange()' style='display: none;'>";
echo "<option disabled selected>-----</option>";
echo "<option value='day'>Dia actual</option>";
echo "<option value='week'>Semana actual</option>";
echo "<option value='month'>Mes actual</option>";
echo "<option value='calendar'>Dia concreto</option>";
echo "</select>";
echo "<input type='date' id='date' onchange='onDateChange()' value=".date("Y-m-d")." min=".date("Y-m-d")." style='display: none;'>";
echo "<button type='submit' id='button-calendar' onclick='selectedCalendarOption()' style='display: none;'>Seleccionar</button>";


?>

<script>

function onResourceChange(){
  document.getElementById("selectCalendario").style.display = "inline";
}

function onCalendarSelectChange(e){
  var select = document.getElementById("selectCalendario");
  var value = select.options[select.selectedIndex].value;
  if(value == "calendar"){
    document.getElementById("date").style.display = "inline";
  } else {
    document.getElementById("date").style.display = "none";
  }
  document.getElementById("button-calendar").style.display = "inline";
}

function selectedCalendarOption(){
  var select = document.getElementById("selectCalendario");
  var value = select.options[select.selectedIndex].value;
  if(value=="calendar"){
    value = document.getElementById("date").value;
  } 
  var resource = document.getElementById("resource").value;
  console.log(select+" "+value+" "+resource);
  if(value=="day")
    window.location.href = "index.php?controller=reservationController&action=showDay&resource="+resource;
  else if(value=="week")
    window.location.href = "index.php?controller=reservationController&action=showWeek&resource="+resource;
  else if(value=="month")
    window.location.href = "index.php?controller=reservationController&action=showMonth&resource="+resource;
  else if(value=="calendar")
    window.location.href = "index.php?controller=reservationController&action=showCalendar&resource="+resource+"&date="+value;
}
</script>