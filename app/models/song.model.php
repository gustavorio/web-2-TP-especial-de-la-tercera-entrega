<?php

    Class SongModel {
        private $db;

        public function __construct() {
            $this->db = new PDO('mysql:host=localhost;dbname=music_player;charset=utf8', 'root', '');
        }

        public function getSongs($genero_id = false, $orderBy = false, $sortOrder = 'ASC', $limit = 10, $offset = 0) {
            $sql = 'SELECT * FROM canciones';
            
            // Arreglo de parámetros para la consulta
            $params = [];
        
            // Condición para filtrar por género
            if ($genero_id) {
                $sql .= ' WHERE genero_id = :genero_id';
                $params[':genero_id'] = $genero_id;
            }
        
            // Validamos si el $sortOrder es 'ASC' o 'DESC' para evitar inyección de SQL
            $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';
        
            // Condición para el orden
            if ($orderBy) {
                switch ($orderBy) {
                    case 'nombre':
                        $sql .= " ORDER BY nombre $sortOrder";
                        break;
                    case 'duracion':
                        $sql .= " ORDER BY duracion $sortOrder";
                        break;
                    case 'artista':
                        $sql .= " ORDER BY artista $sortOrder";
                        break;
                    case 'id':
                        $sql .= " ORDER BY id $sortOrder";
                        break;
                    default:
                        $sql .= " ORDER BY nombre $sortOrder";  // Orden por nombre como predeterminado
                        break;
                }
            } else {
                $sql .= " ORDER BY nombre $sortOrder";  // Orden por nombre si no se especifica otro
            }
        
            // Añadir límite y offset para la paginación
            $sql .= ' LIMIT :limit OFFSET :offset';
            $params[':limit'] = $limit;
            $params[':offset'] = $offset;
        
            // Preparar y ejecutar la consulta con los parámetros
            $query = $this->db->prepare($sql);
        
            // Asignar los parámetros con bindValue
            if ($genero_id) {
                $query->bindValue(':genero_id', $genero_id, PDO::PARAM_INT);
            }
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
        
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
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