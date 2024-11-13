<?php

    Class GenreModel {
        private $db;

        public function __construct() {
            $this->db = new PDO('mysql:host=localhost;dbname=music_player;charset=utf8', 'root', '');
        }

        public function getGenres($año = false, $orderBy = false) {
            $sql = 'SELECT * FROM generos';
        
            // Arreglo de parámetros para la consulta
            $params = [];
        
            // Condición para filtrar por año
            if ($año) {
                $sql .= ' WHERE año = :año';
                $params[':año'] = $año;
            }
        
            // Condición para el orden
            if ($orderBy) {
                switch ($orderBy) {
                    case 'nombre':
                        $sql .= ' ORDER BY nombre ASC';
                        break;
                    case 'id':
                        $sql .= ' ORDER BY id ASC';
                        break;
                    default:
                        $sql .= ' ORDER BY año ASC';  // Orden por año como predeterminado
                        break;
                }
            } else {
                $sql .= ' ORDER BY año ASC';  // Orden por año si no se especifica otro
            }
        
            // Preparar y ejecutar la consulta con los parámetros si existen
            $query = $this->db->prepare($sql);
            
            // Ejecutar la consulta con parámetros, si están definidos
            $query->execute($params);
            
            $generos = $query->fetchAll(PDO::FETCH_OBJ); 
            
            return $generos;
        }
        
        
        public function getGenre($id) {    
            $query = $this->db->prepare('SELECT * FROM generos WHERE id = ?');
            $query->execute([$id]);   
        
            $genero = $query->fetch(PDO::FETCH_OBJ);
        
            return $genero;
        }

        public function insertGenre($nombre, $año, $descripcion) { 
            $query = $this->db->prepare('INSERT INTO generos(nombre, año, descripcion) VALUES (?, ?, ?)');
            $query->execute([$nombre, $año, $descripcion]);
        
            $id = $this->db->lastInsertId();
        
            return $id;
        }

        public function eraseGenre($id) {
            $query = $this->db->prepare('DELETE FROM generos WHERE id = ?');
            $query->execute([$id]);
        }
        
        public function updateGenre($id, $nombre, $año, $descripcion) {        
            $query = $this->db->prepare('UPDATE generos 
                                        SET nombre = ?, 
                                            año = ?,
                                            descripcion = ?    
                                        WHERE id = ?');
            $query->execute([$nombre, $año, $descripcion, $id]);
        } 
        
    }