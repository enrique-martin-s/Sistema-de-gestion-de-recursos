
    <?php
        session_start();


        include_once "models/security.php";

        // Hacemos include de todos los controladores
        foreach (glob("controllers/*.php") as $file) {
            include $file;
        }

        // Miramos el valor de la variable "controller", si existe. Si no, le asignamos un controlador por defecto
        if (isset($_REQUEST["controller"])) {
            $controller = $_REQUEST["controller"];
        } else {
            $controller = "UserController";  // Controlador por defecto
        }

        // Miramos el valor de la variable "action", si existe. Si no, le asignamos una acción por defecto
        if (isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];
        } else {
            $action = "formLogin";  // Acción por defecto
        }

        // Creamos un objeto de tipo $controller y llamamos al método $action()
        $manager = new $controller();
        $manager->$action();

    ?>