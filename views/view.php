<?php

// PLANTILLA DE LAS VISTAS

class View {
    public static function render($nombreVista, $data = null) {
        include("header.php");
        include("nav.php");
        include("$nombreVista.php");
        include("footer.php");
    }
}