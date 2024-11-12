<?php

require_once './app/models/model.php';

class GenreModel extends Model {
    
    public function getGenres() {
        $query = $this->db->prepare('SELECT * FROM genres ORDER BY nombre');
        $query->execute();
        
        $genres = $query->fetchAll(PDO::FETCH_OBJ);
        return $genres;
    }
    
    public function getGenre($id) {
        $query = $this->db->prepare('SELECT * FROM genres WHERE id=?');
        $query->execute([$id]);
        
        $genre = $query->fetch(PDO::FETCH_OBJ);
        return $genre;
    }

    public function saveGenre($genre, $anio, $descripcion, $id = null) {
        if (isset($id)) {
            $query = $this->db->prepare('UPDATE genres SET nombre=?, año=?, descripcion=? WHERE id=?');
            $query->execute([$genre, $anio, $descripcion, $id]);
        } else {
            $query = $this->db->prepare('INSERT INTO genres (nombre, año, descripcion) VALUES (?, ?, ?)');
            $query->execute([$genre, $anio, $descripcion]);

            return $this->db->lastInsertId();
        }
    }

    public function checkGenre($id) {
        //hacemos un query contando si el genero tiene canciones asignadas
        $query = $this->db->prepare('SELECT id FROM songs WHERE genre_id=?');
        $query->execute([$id]);
        $songs= $query->fetchAll(PDO::FETCH_NUM);
        $count = count($songs);

        if ( $count == 0 ) {
            //en caso de no tenerlas, lo borramos sin mas
            $query = $this->db->prepare('DELETE FROM genres where id=?');
            $query->execute([$id]);
        }

        //devolvemos la cantidad de canciones, para darle la eleccion al usuario
        return $count; 
    }

    public function deleteGenre($id) {
        $query = $this->db->prepare('DELETE FROM genres where id=?');
        $query->execute([$id]);
    }
}
