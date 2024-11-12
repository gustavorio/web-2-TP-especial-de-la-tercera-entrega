<?php

require_once './app/controllers/controller.php';
require_once './app/views/song.view.php';
require_once './app/models/song.model.php';
require_once './app/models/genre.model.php';

class SongController extends Controller{
    private $songModel;
    private $genreModel;

    public function __construct() {
        $this->view = new SongView();
        $this->songModel = new SongModel();
        $this->genreModel = new GenreModel();
    }

    public function list($id = null) {
        if ( isset($id) ) {
            //si id != null, pedimos al modelo los datos de la cancion
            $song = $this->songModel->getSong($id);
            //checkeamos si existe en la db
            if ($song) {
                //pedimos el genero correspondiente usando el FK de la cancion, q corresponde al id del genero
                $genre = $this->genreModel->getGenre($song->genre_id);
                //pasamos al view
                $this->view->showSong($song, $genre);
            } else {
                //la cancion no existe en la db
                $this->view->showError('La canción solicitada no existe en nuestra base de datos');
            }
        } else {        
            //le pedimos la lista de canciones y la lista de generos al modelo (para el select del form) y lo pasamos al view
            $songs = $this->songModel->getSongs();
            $genres = $this->genreModel->getGenres();

            $this->view->showSongs($songs, $genres);
        }
    }

    public function save($id = null) {
        //checkeamos que estemos logueado
        AuthHelper::verify();

        //consigo los datos del formulario
        $cancion= $_POST['cancion'];
        $artist= $_POST['artista'];
        $duration= $_POST['duracion'];
        $genre= $_POST['genero'];
        $link= $_POST['link'];
        $letra= $_POST['lyrics'];

        //validaciones
        if (empty($cancion) || empty($artist) || empty($duration) || empty($genre) || empty($link) || empty($letra)) {
            //$this->view->showError("Debe completar todos los campos");
            return;
        }

        if ( isset($id) ) {
            //si se paso id, quiere decir que estoy modificando un item
            $this->songModel->saveSong($cancion, $artist, $duration, $genre, $link, $letra, $id);
            header('Location: ' . BASE_URL . 'songs');
        } else {
            //de no pasarse un id, se agrega un nuevo item
            $set = $this->songModel->saveSong($cancion, $artist, $duration, $genre, $link, $letra, $id);
            if ($set) {
                header('Location: ' . BASE_URL . 'songs');
            } else {
                $this->view->showError("Error al insertar la canción");
            }
        }
    }

    public function remove($id) {
        //checkeamos que estemos logueado
        AuthHelper::verify();
        
        $this->songModel->deleteSong($id);
        header('Location:  ' . BASE_URL . 'songs');                
    }

    public function edit($id) {
        //checkeamos que estemos logueado
        AuthHelper::verify();

        $song = $this->songModel->getSong($id);
        $songs = $this->songModel->getSongs();
        $genres = $this->genreModel->getGenres();
    
        $this->view->editForm($song, $songs, $genres);
    }
}