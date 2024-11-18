# TPE - Trabajo Practico Especial WEB 2 
(este respositorio para tercera entrega con tema de la api restfull, manejo sin dañar el codigo la segunda entrega)
Entrega 18/09/2024 TPE 1°

Entrega 20/10/2024 TPE 2°

Entrega 17/11/2024 TPE 3°

# Integrantes del Proyecto: 

Gustavo Nahuel Rio y Lucas Cueli

## Descripción General
Esta API permite gestionar **géneros musicales**, **canciones** y **usuarios**. No llegamos a añadir los endpoints de modificación (POST, PUT, DELETE) requieren autenticación mediante un **token JWT** que se obtendria a través del endpoint `/usuarios/token`.

---

### Endpoints

#### **1. Generos**

##### **GET /api/generos**
- **Descripción**: Recupera todos los géneros con filtros opcionales.
- **Parámetros opcionales**:
  - `año`: Filtra los géneros por año (puede ser `true` o `false`).
  - `orderBy`: Ordena los géneros por una columna específica. Puede ser `nombre`, `id`, o `año`.
  - `sortOrder`: Define el orden del resultado, puede ser `ASC` (ascendente) o `DESC` (descendente).
  - **Ejemplo de solicitud**:
    ```bash
    GET /api/generos?año=false&orderBy=nombre&sortOrder=ASC
    ```

##### **GET /api/generos/:id**
- **Descripción**: Recupera un género específico por su `id`.
- **Parámetros**:
  - `id`: El ID del género que deseas obtener.
  - **Ejemplo de solicitud**:
    ```bash
    GET /api/generos/5
    ```

##### **POST /api/generos**
- **Descripción**: Crea un nuevo género. Requiere autenticación (token JWT).
- **Parámetros**:
  - `nombre`: Nombre del género.
  - `año`: Año del género.
  - **Ejemplo de solicitud**:
    ```bash
    POST /api/generos
    Content-Type: application/json
    Authorization: Bearer <TOKEN>
    {
      "nombre": "Pop",
      "año": 2024
    }
    ```

##### **PUT /api/generos/:id**
- **Descripción**: Actualiza un género existente por su `id`. Requiere autenticación (token JWT).
- **Parámetros**:
  - `id`: ID del género a actualizar.
  - `nombre`: Nombre del género (opcional).
  - `año`: Año del género (opcional).
  - **Ejemplo de solicitud**:
    ```bash
    PUT /api/generos/5
    Content-Type: application/json
    Authorization: Bearer <TOKEN>
    {
      "nombre": "Pop-Rock",
      "año": 2025
    }
    ```

##### **DELETE /api/generos/:id**
- **Descripción**: Elimina un género por su `id`. Requiere autenticación (token JWT).
- **Parámetros**:
  - `id`: ID del género a eliminar.
  - **Ejemplo de solicitud**:
    ```bash
    DELETE /api/generos/5
    Authorization: Bearer <TOKEN>
    ```

---

#### **2. Canciones**

##### **GET /api/canciones**
- **Descripción**: Recupera todas las canciones con filtros opcionales.
- **Parámetros opcionales**:
  - `genero_id`: Filtra las canciones por género.
  - `orderBy`: Ordena las canciones por una columna específica. Puede ser `nombre`, `duracion`, `artista`, `id`.
  - `sortOrder`: Define el orden del resultado, puede ser `ASC` o `DESC`.
  - `limit`: Número máximo de resultados.
  - `offset`: Desplazamiento de los resultados (para paginación).
  - **Ejemplo de solicitud**:
    ```bash
    GET /api/canciones?genero_id=1&orderBy=nombre&sortOrder=ASC&limit=10&offset=0
    ```

##### **GET /api/canciones/:id**
- **Descripción**: Recupera una canción específica por su `id`.
- **Parámetros**:
  - `id`: El ID de la canción.
  - **Ejemplo de solicitud**:
    ```bash
    GET /api/canciones/5
    ```

##### **POST /api/canciones**
- **Descripción**: Crea una nueva canción. Requiere autenticación (token JWT).
- **Parámetros**:
  - `nombre`: Nombre de la canción.
  - `duracion`: Duración de la canción.
  - `artista`: Artista de la canción.
  - `letra`: Letra de la canción.
  - `url_video`: URL del video de la canción.
  - `genero_id`: ID del género de la canción.
  - **Ejemplo de solicitud**:
    ```bash
    POST /api/canciones
    Content-Type: application/json
    Authorization: Bearer <TOKEN>
    {
      "nombre": "Mi Canción",
      "duracion": "3:45",
      "artista": "Artista X",
      "letra": "Letra de la canción",
      "url_video": "https://youtube.com/video",
      "genero_id": 2
    }
    ```

##### **PUT /api/canciones/:id**
- **Descripción**: Actualiza una canción existente. Requiere autenticación (token JWT).
- **Parámetros**:
  - `id`: ID de la canción.
  - `nombre`: Nombre de la canción (opcional).
  - `duracion`: Duración de la canción (opcional).
  - `artista`: Artista de la canción (opcional).
  - `letra`: Letra de la canción (opcional).
  - `url_video`: URL del video de la canción (opcional).
  - **Ejemplo de solicitud**:
    ```bash
    PUT /api/canciones/5
    Content-Type: application/json
    Authorization: Bearer <TOKEN>
    {
      "nombre": "Nueva Canción",
      "duracion": "4:00"
    }
    ```

##### **DELETE /api/canciones/:id**
- **Descripción**: Elimina una canción por su `id`. Requiere autenticación (token JWT).
- **Parámetros**:
  - `id`: ID de la canción a eliminar.
  - **Ejemplo de solicitud**:
    ```bash
    DELETE /api/canciones/5
    Authorization: Bearer <TOKEN>
    ```

---

#### **3. Usuarios**

##### **GET /api/usuarios/token**
- **Descripción**: Obtiene un token JWT para realizar autenticación en los endpoints de modificación.
- **Parámetros**: Ninguno.
- **Ejemplo de solicitud**:
    ```bash
    GET /api/usuarios/token
    ```

- **Respuesta**:
    ```json
    {
      "token": "<JWT_TOKEN>"
    }
    ```
- Este token debe ser incluido en el encabezado de la solicitud en los endpoints que requieren autenticación:
    ```bash
    Authorization: Bearer <JWT_TOKEN>
    ```

---

### Middleware: Autenticación JWT
El **JWT** es utilizado para proteger los endpoints que requieren autenticación. Este middleware verifica el token enviado en el encabezado de autorización (`Authorization: Bearer <token>`). Si el token no es válido o no está presente, se rechazará la solicitud.

**Ejemplo de una solicitud con el token**:
```bash
GET /api/generos
Authorization: Bearer <JWT_TOKEN>
```

---

### Respuestas y Códigos de Estado

- **200 OK**: Solicitud exitosa.
- **201 Created**: Recurso creado exitosamente.
- **400 Bad Request**: Solicitud incorrecta, generalmente debido a parámetros faltantes o inválidos.
- **401 Unauthorized**: Token JWT no válido o ausente en endpoints protegidos.
- **404 Not Found**: Recurso no encontrado.
- **500 Internal Server Error**: Error en el servidor al procesar la solicitud.

---

### Notas
- Asegúrate de que el **token JWT** esté incluido en el encabezado de la solicitud cuando realices una operación de creación, actualización o eliminación.
- Los filtros en los endpoints de géneros y canciones son completamente opcionales y puedes combinarlos para obtener resultados más específicos.


# Diagrama (DER)
![Diagrama(TPE)](https://github.com/gustavorio/web-2-TP-especial-de-la-tercera-entrega/blob/main/dragon%20music.png)
