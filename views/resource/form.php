<?php
if (isset($data)) {
    extract($data);   
}

if (isset($resource)) {  
    echo "<h1>Modify resources</h1>";
} else {
    echo "<h1>Register a new resource</h1>";
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
        Name:<input type='text' name='name' value='".$name."'><br>
        Description:<input type='text' name='description' value='".$description."'><br>
        Location:<input type='text' name='location' value='".$location."'><br>";
        if($image!=""){
            echo "<img src='".$image."' alt='imagen_recurso' name='image' width='100px' value='".$image."'><br>";
        }
        echo "Image:<input name='subir_archivo' type='file' /><br>";
        echo "<input type='hidden' name='controller' value='resourcesController'>";


if (isset($resource)) {
    echo "  <input type='hidden' name='action' value='modifyResource'>";
} else {
    echo "  <input type='hidden' name='action' value='insertResource'>";
}
echo "	<input type='submit'></form>";
echo "<p><a href='index.php'>Volver</a></p>";