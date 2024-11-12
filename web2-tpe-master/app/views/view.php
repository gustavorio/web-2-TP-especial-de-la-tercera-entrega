<?php

//Su funcion principal es interactuar con las plantillas HTML para mostrar contenido dinamico y errores a los usuarios
class View {
    protected $session;

    public function __construct() {
        $this->session = AuthHelper::check();
    }
    //En caso de que algo falle:
    public function showError($errorString) {
        require './app/templates/error.phtml';
        die();
    }
}