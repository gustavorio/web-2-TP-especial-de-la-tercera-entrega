# TPE - Trabajo Practico Especial WEB 2 
(este respositorio para tercera entrega con tema de la api restfull, manejo sin dañar el codigo la segunda entrega)
Entrega 18/09/2024 TPE 1°

Entrega 20/10/2024 TPE 2°

Entrega 17/11/2024 TPE 3°

# Integrantes del Proyecto: 

Gustavo Nahuel Rio y Lucas Cueli

# Documentación de la API

Esta API permite la gestión de géneros y canciones en una base de datos. A continuación, se describen los endpoints, los métodos HTTP correspondientes, y ejemplos de uso.

# Documentación de la API

Esta API permite gestionar géneros y canciones en una base de datos. Los endpoints incluyen opciones de filtrado y ordenamiento para una mayor flexibilidad.

## Endpoints de la API

---

### Géneros

1. **Obtener todos los géneros (con filtros opcionales)**
   - **Endpoint:** `/generos`
   - **Método:** GET
   - **Descripción:** Devuelve una lista de todos los géneros, con la opción de filtrar por año y ordenar por nombre, ID o año.
   - **Parámetros opcionales:**
     - `año`: Filtra los géneros según el año especificado.
     - `orderBy`: Ordena la lista por el campo especificado (`nombre`, `id`, o `año`).
   - **Ejemplo de uso:**
     ```bash
     curl -X GET "http://localhost/generos?año=1990&orderBy=nombre"
     ```

2. **Obtener un género por ID**
   - **Endpoint:** `/generos/:id`
   - **Método:** GET
   - **Descripción:** Devuelve un género específico según su ID.
   - **Ejemplo de uso:**
     ```bash
     curl -X GET "http://localhost/generos/1"
     ```

3. **Eliminar un género**
   - **Endpoint:** `/generos/:id`
   - **Método:** DELETE
   - **Descripción:** Elimina un género según su ID.
   - **Ejemplo de uso:**
     ```bash
     curl -X DELETE "http://localhost/generos/1"
     ```

4. **Crear un género**
   - **Endpoint:** `/generos`
   - **Método:** POST
   - **Descripción:** Crea un nuevo género.
   - **Datos requeridos en el cuerpo:**
     - `nombre` (string): Nombre del género.
     - `año` (integer): Año de origen del género.
   - **Ejemplo de uso:**
     ```bash
     curl -X POST "http://localhost/generos" -d '{"nombre": "Jazz", "año": 1920}'
     ```

5. **Actualizar un género**
   - **Endpoint:** `/generos/:id`
   - **Método:** PUT
   - **Descripción:** Actualiza la información de un género.
   - **Datos requeridos en el cuerpo:**
     - `nombre` (string): Nombre del género.
     - `año` (integer): Año de origen del género.
   - **Ejemplo de uso:**
     ```bash
     curl -X PUT "http://localhost/generos/1" -d '{"nombre": "Rock", "año": 1955}'
     ```

---

### Canciones

1. **Obtener todas las canciones (con filtros opcionales)**
   - **Endpoint:** `/canciones`
   - **Método:** GET
   - **Descripción:** Devuelve una lista de todas las canciones, con la opción de filtrar por género y ordenar por nombre, duración, artista o ID.
   - **Parámetros opcionales:**
     - `genero_id`: Filtra las canciones por el ID del género asociado.
     - `orderBy`: Ordena la lista por el campo especificado (`nombre`, `duracion`, `artista`, o `id`).
   - **Ejemplo de uso:**
     ```bash
     curl -X GET "http://localhost/canciones?genero_id=2&orderBy=artista"
     ```

2. **Obtener una canción por ID**
   - **Endpoint:** `/canciones/:id`
   - **Método:** GET
   - **Descripción:** Devuelve una canción específica según su ID.
   - **Ejemplo de uso:**
     ```bash
     curl -X GET "http://localhost/canciones/1"
     ```

3. **Eliminar una canción**
   - **Endpoint:** `/canciones/:id`
   - **Método:** DELETE
   - **Descripción:** Elimina una canción según su ID.
   - **Ejemplo de uso:**
     ```bash
     curl -X DELETE "http://localhost/canciones/1"
     ```

4. **Crear una canción (máximo 3 canciones por género)**
   - **Endpoint:** `/canciones`
   - **Método:** POST
   - **Descripción:** Crea una nueva canción asociada a un género. **Nota:** Solo se pueden agregar hasta 3 canciones por género.
   - **Datos requeridos en el cuerpo:**
     - `nombre` (string): Nombre de la canción.
     - `duracion` (time): Duración de la canción.
     - `artista` (string): Nombre del artista.
     - `letra` (text): Letra de la canción.
     - `url_video` (text): URL del video de la canción.
     - `genero_id` (integer): ID del género asociado.
   - **Restricción:** Si ya existen 3 canciones para el género indicado (`genero_id`), el servidor devuelve un mensaje de error.
   - **Ejemplo de uso:**
     ```bash
     curl -X POST "http://localhost/canciones" -d '{"nombre": "Imagine", "duracion": "03:04", "artista": "John Lennon", "letra": "...", "url_video": "http://youtube.com/...", "genero_id": 2}'
     ```

5. **Actualizar una canción**
   - **Endpoint:** `/canciones/:id`
   - **Método:** PUT
   - **Descripción:** Actualiza la información de una canción.
   - **Datos requeridos en el cuerpo:**
     - `nombre` (string): Nombre de la canción.
     - `duracion` (time): Duración de la canción.
     - `artista` (string): Nombre del artista.
     - `letra` (text): Letra de la canción.
     - `url_video` (text): URL del video de la canción.
     - `genero_id` (integer): ID del género asociado.
   - **Ejemplo de uso:**
     ```bash
     curl -X PUT "http://localhost/canciones/1" -d '{"nombre": "Hey Jude", "duracion": "07:04", "artista": "The Beatles", "letra": "...", "url_video": "http://youtube.com/...", "genero_id": 1}'
     ```

---

Cada endpoint devuelve respuestas en formato JSON, que incluyen los datos solicitados o mensajes de error en caso de fallo.


# Diagrama (DER)
![Diagrama(TPE)](https://github.com/gustavorio/web-2-TP-especial-de-la-tercera-entrega/blob/main/dragon%20music.png)
