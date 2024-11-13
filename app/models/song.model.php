<?php

    Class SongModel {
        private $db;

        public function __construct() {
            $this->db = new PDO('mysql:host=localhost;dbname=music_player;charset=utf8', 'root', '');
        }

        public function getSongs($genero_id = false, $orderBy = false) {
            $sql = 'SELECT * FROM canciones';
            
            // Arreglo de parámetros para la consulta
            $params = [];
            
            // Condición para filtrar por género
            if ($genero_id) {
                $sql .= ' WHERE genero_id = :genero_id';
                $params[':genero_id'] = $genero_id;
            }
        
            // Condición para el orden
            if ($orderBy) {
                switch ($orderBy) {
                    case 'nombre':
                        $sql .= ' ORDER BY nombre ASC';
                        break;
                    case 'duracion':
                        $sql .= ' ORDER BY duracion ASC';
                        break;
                    case 'artista':
                        $sql .= ' ORDER BY artista ASC';
                        break;
                    case 'id':
                        $sql .= ' ORDER BY id ASC';
                        break;
                    default:
                        $sql .= ' ORDER BY nombre ASC';  // Orden por nombre como predeterminado
                        break;
                }
            } else {
                $sql .= ' ORDER BY nombre ASC';  // Orden por nombre si no se especifica otro
            }
        
            // Preparar y ejecutar la consulta con los parámetros si existen
            $query = $this->db->prepare($sql);
            
            // Ejecutar la consulta con parámetros, si están definidos
            $query->execute($params);
            
            $canciones = $query->fetchAll(PDO::FETCH_OBJ); 
            
            return $canciones;
        }
        
        
        public function getSong($id) {    
            $query = $this->db->prepare('SELECT * FROM canciones WHERE id = ?');
            $query->execute([$id]);   
        
            $cancion = $query->fetch(PDO::FETCH_OBJ);
        
            return $cancion;
        }

        public function countSongsByGenre($genero_id) {
            $sql = 'SELECT COUNT(*) as cantidad FROM canciones WHERE genero_id = ?';
            $query = $this->db->prepare($sql);
            $query->execute([$genero_id]);
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result->cantidad;
        }

        public function insertSong($nombre, $duracion, $artista, $letra, $url, $genero ) { 
            $query = $this->db->prepare('INSERT INTO canciones(nombre, duracion, artista, letra, url_video, genero_id) VALUES (?, ?, ?, ?, ?, ?)');
            $query->execute([$nombre, $duracion, $artista, $letra, $url, $genero]);
        
            $id = $this->db->lastInsertId();
        
            return $id;
        }

        public function eraseSong($id) {
            $query = $this->db->prepare('DELETE FROM canciones WHERE id = ?');
            $query->execute([$id]);
        }
        
        public function updateSong($id, $nombre, $duracion, $artista, $letra, $url, $genero) {        
            $query = $this->db->prepare('UPDATE canciones 
                                        SET nombre = ?, 
                                            duracion = ?,
                                            artista = ?,
                                            letra = ?,
                                            url_video = ?,
                                            genero_id = ?   
                                        WHERE id = ?');
            $query->execute([ $nombre, $duracion, $artista, $letra, $url, $genero, $id]);
        } 
        
    }