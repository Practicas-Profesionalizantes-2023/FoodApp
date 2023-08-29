<?php

class Session{

    private $sessionName = 'user';

    public function __construct() {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    public function setCurrentUser($user) {
        $_SESSION[$this->sessionName]= $user;
    }

    public function getCurrentUser() {
        return isset($_SESSION[$this->sessionName]) ? $_SESSION[$this->sessionName] : null;
    }

    public function CloseSession() {
        session_unset();
        session_destroy();
    }

    public function exists(){
        return isset($_SESSION[$this->sessionName]);
    }

}



?>