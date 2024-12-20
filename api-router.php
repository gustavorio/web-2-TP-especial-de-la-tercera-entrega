<?php
    
    require_once 'libs/router.php';
    require_once 'app/controllers/user.api.controller.php';
    require_once 'app/controllers/genre.api.controller.php';
    require_once 'app/controllers/song.api.controller.php';
    require_once 'app/middlewares/jwt.auth.middleware.php';

    $router = new Router();
    $router->addMiddleware(new JWTAuthMiddleware());

    #GENEROS           endpoint           verbo            controller            metodo
    $router->addRoute('generos'    ,    'GET',       'GenreApiController',   'getAll');
    $router->addRoute('generos/:id',    'GET',       'GenreApiController',   'get');
    $router->addRoute('generos/:id',    'DELETE',    'GenreApiController',   'delete');
    $router->addRoute('generos'    ,    'POST',      'GenreApiController',   'create');
    $router->addRoute('generos/:id',    'PUT',       'GenreApiController',   'update');

    #CANCIONES         endpoint             verbo           controller          metodo            
    $router->addRoute('canciones'   ,      'GET',      'SongApiController',    'getAll');
    $router->addRoute('canciones/:id',      'GET',      'SongApiController',    'get');
    $router->addRoute('canciones/:id',      'DELETE',   'SongApiController',    'delete'); 
    $router->addRoute('canciones'   ,      'POST',     'SongApiController',    'create');
    $router->addRoute('canciones/:id',      'PUT',      'SongApiController',    'update');

    #USUARIOS           endpoint             verbo          controller             metodo 
    $router->addRoute('usuarios/token',      'GET',      'UserApiController',    'getToken');


    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);