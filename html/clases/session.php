<?php

class Session{

    private $sessionName = 'user';

    public function __construct() {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    public function setCurrentUser($user) {
        $_SESSION[$this->sessionNme]= $user;
    }

    public function getCurrentUser() {
        return $_SESSION[$this->sessionNme];
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