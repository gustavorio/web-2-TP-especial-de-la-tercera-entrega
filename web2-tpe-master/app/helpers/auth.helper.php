<?php

class AuthHelper {

    //Verifica si la sesion ya esta activa, si no lo esta inicia una nueva o reanuda la que estaba
    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    //Se utiliza para autenticar a un usuario, llama a "init" para asegurarse que la sesion este activa. Permite que la aplicacion reconozca al usuario en futuras solicitudes
    public static function login($user) {
        AuthHelper::init();
        $_SESSION['USER_ID'] = $user->id;
        $_SESSION['USER_NAME'] = $user->username; 
    }

    //Se encarga de cerrar la sesion del usuario
    public static function logout() {
        AuthHelper::init();
        session_destroy();
    }

    //Revisa si algun usuario inicio sesion, tambien llama a "init" para asegurarse de que la sesion este activa, en caso de que no lo redirige a la pagina de inicio de sesion (definida por BASE_URL . 'login')
    public static function verify() {
        AuthHelper::init();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . 'login');
            die();
        }
    }

    //Verifica si el usuario esta actualmente autenticado, devuelve "true" si ha iniciado sesion , "false" en caso contrario. Permite que otras partes comprueben rapidamente el estado de autenticacion del usuario
    public static function check() {
        AuthHelper::init();
        return isset($_SESSION['USER_ID']);
    }
}