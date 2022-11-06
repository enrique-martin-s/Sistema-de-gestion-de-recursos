<?php
if (isset($data)) {
    extract($data);   
}

if (isset($resource)) {  
    echo "<h1>Modifica el recurso</h1>";
} else {
    echo "<h1>Registra un nuevo recurso</h1>";
}

// Sacamos los datos del resource (si existe) a variables individuales para mostrarlo en los inputs del formulario.
// (Si no hay resource, dejamos los campos en blanco y el formulario servirá para inserción).
$id = $resource->id ?? ""; 
$name = $resource->name ?? "";
$description = $resource->description ?? "";
$location = $resource->location ?? "";
$image = $resource->image ?? "";

// Creamos el formulario con los campos del resource
echo "<form action = 'index.php' method = 'post' enctype='multipart/form-data'>
        <input type='hidden' name='id' value='".$id."'>
        Nombre:<input type='text' name='name' value='".$name."'><br>
        Descripcion:<input type='text' name='description' value='".$description."'><br>
        Lugar:<input type='text' name='location' value='".$location."'><br>";
        if($image!=""){

            echo "<input type='hidden' name='image' value='".$image."'> 
            <img src='".$image."' alt='imagen_recurso' name='cosa' width='100px' ><br>";
        }
        echo "Imagen:<input name='subir_archivo' type='file' /><br>";
        echo "<input type='hidden' name='controller' value='resourcesController'>";


if (isset($resource)) {
    echo "  <input type='hidden' name='action' value='modifyResource'>";
} else {
    echo "  <input type='hidden' name='action' value='insertResource'>";
}
echo "	<input type='submit'></form>";
echo "<p><a href='index.php?controller=resourcesController&action=showResources'>Volver</a></p>";