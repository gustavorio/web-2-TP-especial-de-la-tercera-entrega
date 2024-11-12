<?php

require_once './app/models/model.php';

class SongModel extends Model {

    public function getSongs() {
        // Realizamos el JOIN entre songs y genres para obtener el nombre del género
        $query = $this->db->prepare("
            SELECT songs.*, genres.nombre AS genre_name
            FROM songs
            JOIN genres ON songs.genre_id = genres.id
            ORDER BY songs.title
        ");
        $query->execute();
        
        // Obtenemos todas las canciones con el nombre del género
        $songs = $query->fetchAll(PDO::FETCH_OBJ);
        return $songs;
    }
        

    public function getSong($id) {
        $query = $this->db->prepare('SELECT * FROM songs WHERE id=?');
        $query->execute([$id]);
    
        $song = $query->fetch(PDO::FETCH_OBJ);
        return $song;
    }

    public function getGenreSongs($genre_id) {
        $query = $this->db->prepare('SELECT * FROM songs WHERE genre_id=? ORDER BY title');
        $query->execute([$genre_id]);

        $songs = $query->fetchAll(PDO::FETCH_OBJ);
        return $songs;
    }

    public function saveSong($song, $artist, $duration, $genre, $link, $letra, $id = null) {
        if (isset($id)) {
            // Corregir la consulta de actualización con la coma faltante
            $query = $this->db->prepare('UPDATE songs SET title=?, artist=?, duration=?, link=?, lyrics=?, genre_id=? WHERE id=?');
            $query->execute([$song, $artist, $duration, $link, $letra, $genre, $id]);
        } else {
            // Verifica si el genre_id es válido antes de intentar la inserción
            if ($this->isValidGenre($genre)) {
                $query = $this->db->prepare('INSERT INTO songs (title, artist, duration, link, lyrics, genre_id) VALUES(?, ?, ?, ?, ?, ?)');
                $query->execute([$song, $artist, $duration, $link, $letra, $genre]);
    
                return $this->db->lastInsertId();
            } else {
                throw new Exception("Invalid genre_id: $genre");
            }
        }
    }
    
    // Función para validar si el genre_id existe en la tabla genres
    private function isValidGenre($genre_id) {
        $query = $this->db->prepare("SELECT id FROM genres WHERE id = ?");
        $query->execute([$genre_id]);
        return $query->fetch(PDO::FETCH_OBJ) !== false;
    }
    

    public function deleteSong($id) {
        $query = $this->db->prepare('DELETE FROM songs WHERE id=?');
        $query->execute([$id]);
    }
}