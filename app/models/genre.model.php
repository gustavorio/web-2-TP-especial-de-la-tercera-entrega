<?php

    Class GenreModel {
        private $db;

        public function __construct() {
            $this->db = new PDO('mysql:host=localhost;dbname=music_player;charset=utf8', 'root', '');
        }

        public function getGenres($año = false, $orderBy = false, $sortOrder = 'ASC', $limit = 10, $offset = 0) {
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
                // Validamos si el $sortOrder es 'ASC' o 'DESC' para evitar inyección de SQL
                $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';
            
                switch ($orderBy) {
                    case 'nombre':
                        $sql .= " ORDER BY nombre $sortOrder";
                        break;
                    case 'id':
                        $sql .= " ORDER BY id $sortOrder";
                        break;
                    default:
                        $sql .= " ORDER BY año $sortOrder";  // Orden por año como predeterminado
                        break;
                }
            } else {
                $sql .= " ORDER BY año $sortOrder";  // Orden por año si no se especifica otro
            }
        
            // Asegurarse de que los valores de limit y offset sean enteros
            $limit = (int)$limit;
            $offset = (int)$offset;
            
            // Agregar limit y offset para la paginación (incluirlos directamente en la consulta)
            $sql .= " LIMIT $limit OFFSET $offset";
            
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