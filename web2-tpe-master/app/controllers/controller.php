<?php

require_once './app/views/view.php';

class Controller {

    protected $view;

    public function __construct() {
        $this->view = new View();
    }

    //Cada vez que hay un error, el controlador utiliza la vista para mostrar una página de error con un mensaje específico.
    public function showError($errorString = null) {
        $errorString = ( !isset($errorString) ) ? '404 - pagina no encontrada' : $errorString;
        $this->view->showError($errorString);
    }
}