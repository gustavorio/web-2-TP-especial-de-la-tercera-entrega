<?php

require_once './app/views/view.php';

class GenreView extends View{

    public function showGenres($genres) {
        //seteamos el form para AGREGAR generos
        $form = './app/templates/form.add.genre.phtml';  
        require './app/templates/list.genres.phtml';
    }

    public function showGenre($genre, $songs) {
        $tracks = count($songs);
        require './app/templates/detail.genre.phtml';
    }

    public function editForm($genre, $genres) {
        //seteamos el form para EDITAR albumes
        $form = './app/templates/form.edit.genre.phtml';
        require './app/templates/list.genres.phtml';
    }

    public function removeConfirmation($count, $id, $genres) {
        //seteamos el form para BORRAR genre y sus dependencias
        $form = './app/templates/form.remove.genre.phtml';
        require './app/templates/list.genres.phtml';
    }

    /*public function showError($error) {
        require 'templates/error.phtml';
    }*/
}
