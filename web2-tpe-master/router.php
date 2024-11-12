<?php
require_once './app/config/config.php';
require_once './app/controllers/genre.controller.php';
require_once './app/controllers/song.controller.php';
require_once './app/controllers/auth.controller.php';

$action = 'genres'; //accion por defecto
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

//parsea la action para separar accion de parametros
function parseUrl($url) {
    $url_data = explode("/", $url);
    $url_action = explode("-", $url_data[0]);

    $arrayReturn['category'] = $url_action[0];
    $arrayReturn['fullaction'] = $url_data[0];
    $arrayReturn['id'] = isset($url_data[1]) && $url_data[1] != "" ? $url_data[1] : null;

    return $arrayReturn;
}

/*                                  --- TABLA DE ROUTING ---

genres              ->      GenreController()->list();          -Lista todos los generos
genres/id           ->      GenreController()->list($id);       -Lista el detalle de un genero
genres-save         ->      GenreController()->save();          -Guarda un nuevo genero desde el form de alta
genres-edit/id      ->      GenreController()->edit($id);       -Carga el form de edicion
genres-save/id      ->      GenreController()->save($id);       -Guarda modificaciones a ungenero desde el form de edicion
genres-remove/id    ->      GenreController()->remove($id);     -Elimina un genero si no tiene dependencias, de tenerlas da la eleccion al usuario
genres-rmvall/id    ->      GenreController()->rmvall($id);     -Elimina un genero y todas sus dependencias 

songs               ->      SongController()->list();           -Lista todas las canciones
songs/id            ->      SongController()->list($id);        -Lista el detalle de una cancion
songs-save          ->      SongController()->save();           -Guarda una nueva cancion desde el form de alta
songs-edit/id       ->      SongController()->edit($id);        -Carga el form de edicion
songs-save/id       ->      SongController()->save($id);        -Guarda modificaciones a una cancion desde el form de edicion
songs-remove/id     ->      SongController()->remove($id);      -Elimina una cancion

login               ->      AuthController()->login();          -Muestra la seccion de login
auth                ->      AuthController()->auth();           -Autentica al usuario
logout              ->      AuthController()->logout();         -Desloguea al usuario
default             ->      Controller->showError($error=null); -Muestra un error, por defecto 404

*/

$params = parseUrl($action);
$contr;

switch ($params['category']) {
    case 'genres':  $contr = new GenreController(); break;
    case 'songs':   $contr = new SongController();  break;
    case 'login':
    case 'auth':
    case 'logout':  $contr = new AuthController();  break;

    default:        $contr = new Controller();
                    $contr->showError();
}

switch ($params['fullaction']) {
    case 'genres':          $contr->list($params['id']);    break;
    case 'genres-save':     $contr->save($params['id']);    break;
    case 'genres-edit':     $contr->edit($params['id']);    break;
    case 'genres-remove':   $contr->remove($params['id']);  break;
    case 'genres-rmvall':   $contr->rmvall($params['id']);  break;
    
    case 'songs':           $contr->list($params['id']);    break;
    case 'songs-save':      $contr->save($params['id']);    break;
    case 'songs-edit':      $contr->edit($params['id']);    break;
    case 'songs-remove':    $contr->remove($params['id']);  break;

    case 'login':           $contr->login();                break;
    case 'auth':            $contr->auth();                 break;
    case 'logout';          $contr->logout();               break;

    default:                $contr->showError();
}