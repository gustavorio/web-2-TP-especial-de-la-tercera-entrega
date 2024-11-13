<?php
require_once './app/models/genre.model.php';
require_once './app/views/json.view.php';

class GenreApiController{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new GenreModel();
        $this->view = new JSONView();
    }

    // /api/generos
    public function getAll($req, $res) {
        $año = false;
        // Verificar si el año está en los parámetros de la URL
        if (isset($req->query->año) && $req->query->año == 'false') {
            $año = true;
        }
    
        // Ordenar por columna si está especificado en los parámetros de la URL
        $orderBy = false;
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }
    
        // Orden ascendente o descendente si está especificado en los parámetros de la URL
        $sortOrder = 'ASC'; // Valor predeterminado
        if (isset($req->query->sortOrder) && in_array(strtoupper($req->query->sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = strtoupper($req->query->sortOrder);
        }
    
        // Paginación: obtener limit y page de los parámetros
        $limit = 10; // Valor predeterminado
        if (isset($req->query->limit)) {
            $limit = (int)$req->query->limit;
        }
    
        $page = 1; // Valor predeterminado
        if (isset($req->query->page)) {
            $page = (int)$req->query->page;
        }
    
        // Calcular el offset para la consulta
        $offset = ($page - 1) * $limit;
    
        // Obtener los géneros filtrados, ordenados y paginados desde el modelo
        $generos = $this->model->getGenres($año, $orderBy, $sortOrder, $limit, $offset);
    
        // Responder con los géneros a la vista
        return $this->view->response($generos);
    }

    // /api/tareas/:id
    public function get($req, $res) {
        // obtengo el id del genero desde la ruta
        $id = $req->params->id;

        // obtengo el genero de la DB
        $genero = $this->model->getGenre($id);

        if(!$genero) {
            return $this->view->response("El Genero con el id=$id no existe", 404);
        }

        // mando el genero a la vista
        return $this->view->response($genero);
    }

    // /api/generos/:id (DELETE)
    public function delete($req, $res){
        $id = $req->params->id;

        $genero = $this->model->getGenre($id);

        if(!$genero) {
            return $this->view->response("El Genero con el id=$id no existe", 404);
        }

        $this->model->eraseGenre($id);
        $this->view->response('El Genero con se elimino con exito', 200);
    }

    // /api/generos (POST)
    public function create($req, $res){        
    
        //valido los datos
        if(empty($req->body['nombre']) || empty($req->body['año']) || empty($req->body['descripcion'])){
           return $this->view->response("Faltan completar datos", 400);
        } 

        //obtengo los datos
        $nombre = $req->body['nombre'];
        $año = $req->body['año'];
        $descripcion = $req->body['descripcion'];
        //inserto los datos
        $id = $this->model->insertGenre($nombre, $año, $descripcion );
    
            if (!$id){
            return $this->view->response("Error al insertar Genero", 500);
        }

        // Buena practica es devolver el recurso insertado
        $genero = $this->model->getGenre($id);
        return $this->view->response($genero, 201);
    }

    // api/generos/:id (PUT)
    public function update($req, $res){
        $id = $req->params->id;

        $genero = $this->model->getGenre($id);

        //Verifica que exista
        if(!$genero) {
            return $this->view->response("El Genero con el id=$id no existe", 404);
        }

        //valido los datos
        if(empty($req->body['nombre']) || empty($req->body['descripcion']) || empty($req->body['año'])){
            return $this->view->response("Faltan completar datos", 400);
        } 

        //obtengo los datos
        $nombre = $req->body['nombre'];
        $descripcion = $req->body['descripcion'];
        $año = $req->body['año'];

        //Actualiza la tarea
        $this->model->updateGenre($id, $nombre, $año, $descripcion);

        //Obtengo la tarea modificada y la devuelvo en la respuesta
        $genero = $this->model->getGenre($id);
        $this->view->response($genero, 200);
 
    }

}