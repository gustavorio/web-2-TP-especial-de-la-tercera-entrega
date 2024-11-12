<?php

require_once './app/controllers/controller.php';
require_once './app/views/genre.view.php';
require_once './app/models/genre.model.php';
require_once './app/models/song.model.php';

class GenreController extends Controller {
    private $genreModel;
    private $songModel;

    public function __construct() {
        $this->view = new GenreView();
        $this->genreModel = new GenreModel();
        $this->songModel = new SongModel();
    }

    public function list($id = null) {
        if ( isset($id) ) {
            //si id tiene un valor, pedimos al modelo el album correspondiente
            $genre = $this->genreModel->getGenre($id);
            if ($genre) {
                //pedimos las canciones correspondientes al album
                $songs = $this->songModel->getGenreSongs($id);
                //le pasamos todo al view
                $this->view->showGenre($genre, $songs);
            } else {
                //el album no existe en la db
                $this->view->showError('El genero solicitado no existe en nuestra base de datos');
            }
        } else {
            //le pedimos la lista de musica al modelo
            $genres = $this->genreModel->getGenres();

            //mandamos la lista a la vista para que la muestre
            $this->view->showGenres($genres);
        }
    }

    public function save($id = null) {
        //checkeamos que estemos logueado
        AuthHelper::verify();

        //consigo los datos del formulario
        $genre= $_POST['nombre'];
        $anio= $_POST['anio'];
        $descripcion= $_POST['descripcion'];

        //validaciones
        if ( empty($genre) || empty($anio) || empty($descripcion) ) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }

        if ( isset($id) ) {
            //si se paso id, quiere decir que estoy modificando un item
            $this->genreModel->saveGenre($genre, $anio, $descripcion, $id);
            header('Location: ' . BASE_URL . 'genres');
        } else {
            //de no pasarse un id, se agrega un nuevo item
            $set = $this->genreModel->saveGenre($genre, $anio, $descripcion);
            if ($set) {
                header('Location: ' . BASE_URL . 'genres');
            } else {
                $this->view->showError("Error al insertar el Genero");
            }
        }
    }

    public function remove($id) {
        //checkeamos que estemos logueado
        AuthHelper::verify();

        $count = $this->genreModel->checkGenre($id);
        if ( $count > 0 ) {
            $genres = $this->genreModel->getGenres();
            $this->view->removeConfirmation($count, $id, $genres);
        } else {
            header('Location: ' . BASE_URL . 'genres');                
        }
    }

    public function rmvall($id) {
        //checkeamos que estemos logueado
        AuthHelper::verify();

        //conseguimos los items a borrar
        $songs = $this->songModel->getGenreSongs($id);
        $genre = $this->genreModel->getGenre($id);
        //borramos todas las canciones primero
        foreach ($songs as $song) { $this->songModel->deleteSong($song->id); }
        //finalmente el genero
        $this->genreModel->deleteGenre($id);

        header('Location: ' . BASE_URL . 'genres');                
    }

    public function edit($id) {
        //checkeamos que estemos logueado
        AuthHelper::verify();

        //conseguimos los datos del item a editar
        $genre = $this->genreModel->getGenre($id);
        $genres= $this->genreModel->getGenres();

        $this->view->editForm($genre, $genres);
    }
}