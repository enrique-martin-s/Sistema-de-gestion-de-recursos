<?php

// PLANTILLA DE LAS VISTAS

class View {
    public static function render($nombreVista, $data = null) {
        include("headerClean.php");
        include("title.php");
        include("nav.php");
        include("$nombreVista.php");
        include("footer.php");
    }
    public static function renderLogin($nombreVista, $data = null) {
        include("headerClean.php");
        include("$nombreVista.php");
    }
}