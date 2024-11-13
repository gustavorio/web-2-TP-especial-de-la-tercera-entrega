<?php
    class Request {
        public $body = null; # { nombre: 'Saludar', descripcion: 'Saludar a todos' }
        public $params = null; # /api/generos/:id
        public $query = null; # ?año=true

        public function __construct() {
            try {
                # file_get_contents('php://input') lee el body de la request
                $this->body = json_decode(file_get_contents('php://input'), true);
            }
            catch (Exception $e) {
                $this->body = null;
            }
            $this->query = (object) $_GET;
        }
    }