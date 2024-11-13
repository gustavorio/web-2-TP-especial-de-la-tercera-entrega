<?php
require_once './app/models/song.model.php';
require_once './app/views/json.view.php';

class SongApiController{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SongModel();
        $this->view = new JSONView();
    }

    // /api/canciones
    public function getAll($req, $res) {
        // Filtrar por género si está en los parámetros de la URL
        $genero_id = false;
        if (isset($req->query->genero_id)) {
            $genero_id = $req->query->genero_id;
        }
        
        // Ordenar por columna si está especificado en los parámetros de la URL
        $orderBy = false;
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }
    
        // Orden ascendente o descendente si está especificado en los parámetros de la URL
        $sortOrder = 'ASC'; // valor predeterminado
        if (isset($req->query->sortOrder) && in_array(strtoupper($req->query->sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = strtoupper($req->query->sortOrder);
        }
    
        // Parámetros de paginación
        $limit = isset($req->query->limit) ? (int)$req->query->limit : 10; // límite predeterminado de canciones por página
        $page = isset($req->query->page) ? (int)$req->query->page : 1; // página predeterminada es 1
    
        // Calcular el offset para la paginación
        $offset = ($page - 1) * $limit;
    
        // Llamar al modelo para obtener las canciones filtradas, ordenadas y paginadas
        $canciones = $this->model->getSongs($genero_id, $orderBy, $sortOrder, $limit, $offset);
    
        // Responder con las canciones a la vista
        return $this->view->response($canciones);
    }

    
    // /api/canciones/:id
    public function get($req, $res) {
        // obtengo el id de la cancion desde la ruta
        $id = $req->params->id;

        // obtengo de la id de la cancion de la DB
        $cancion = $this->model->getSong($id);

        if(!$cancion) {
            return $this->view->response("La cancion con el id=$id no existe", 404);
        }

        // mando el genero a la vista
        return $this->view->response($cancion);
    }

    // /api/canciones/:id (DELETE)
    public function delete($req, $res){
        $id = $req->params->id;

        $cancion = $this->model->getSong($id);

        if(!$cancion) {
            return $this->view->response("La Cancion con el id=$id no existe", 404);
        }

        $this->model->eraseSong($id);
        $this->view->response('La Cancion con se elimino con exito', 200);
    }

    // /api/canciones (POST)
    public function create($req, $res) {        

        // Validar los datos
        if (empty($req->body['nombre']) || empty($req->body['artista']) || empty($req->body['genero_id'])) {
            return $this->view->response("Faltan completar datos", 400);
        }

        // Obtener los datos
        $nombre = $req->body['nombre'];
        $duracion = $req->body['duracion'];
        $artista = $req->body['artista'];
        $letra = $req->body['letra'];
        $url = $req->body['url_video'];
        $genero = $req->body['genero_id'];

        // Verificar si ya existen 3 canciones en el género
        $cantidadCanciones = $this->model->countSongsByGenre($genero);
        if ($cantidadCanciones >= 3) {
            return $this->view->response("No se pueden agregar más de 3 canciones para este género", 400);
        }

        // Insertar la canción si el género tiene menos de 3 canciones
        $id = $this->model->insertSong($nombre, $duracion, $artista, $letra, $url, $genero);

        if (!$id) {
            return $this->view->response("Error al insertar canción", 500);
        }

        // Buena práctica: devolver el recurso insertado
        $cancion = $this->model->getSong($id);
        return $this->view->response($cancion, 201);
    }

    // api/canciones/:id (PUT)
    public function update($req, $res){
        $id = $req->params->id;

        $cancion = $this->model->getSong($id);

        //Verifica que exista
        if(!$cancion) {
            return $this->view->response("La Cancion con el id=$id no existe", 404);
        }

        // Validar los datos
        if (empty($req->body['nombre']) || empty($req->body['artista']) || empty($req->body['genero_id'])) {
            return $this->view->response("Faltan completar datos", 400);
        }

        // Obtener los datos
        $nombre = $req->body['nombre'];
        $duracion = $req->body['duracion'];
        $artista = $req->body['artista'];
        $letra = $req->body['letra'];
        $url = $req->body['url_video'];
        $genero = $req->body['genero_id'];

        //Actualiza la cancion
        $this->model->updateSong($id, $nombre, $duracion, $artista, $letra, $url, $genero);

        //Obtengo la cancion modificada y la devuelvo en la respuesta
        $cancion = $this->model->getSong($id);
        $this->view->response($cancion, 200);
 
    }

}