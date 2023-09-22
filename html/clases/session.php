<?php

class Session{


    
    private $sessionId = 'user_id';
    private $sessionName = 'user_name';
    private $sessionN = 'user_N';
    private $sessionRole = 'user_role';
    private $sessionRoleName = 'user_roleName';
    private $sessionState = 'user_state';
    
    public function __construct() {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    public function setCurrentUserId($userId) {
        error_log('SESSION::setCurrentUser -> variable user = '. $userId);
      
        $_SESSION[$this->sessionId]= $userId;
    } 
    public function setCurrentUserName($userName) {
        error_log('SESSION::setCurrentUser -> variable user = '. $userName);
      
        $_SESSION[$this->sessionName]= $userName;
    } 
    public function setCurrentUserN($userN) {
        error_log('SESSION::setCurrentUser -> variable user = '. $userN);
      
        $_SESSION[$this->sessionN]= $userN;
    } 

    public function setCurrentUserRole($userRole) {
        error_log('SESSION::setCurrentUser -> variable user = '. $userRole);
      
        $_SESSION[$this->sessionRole]= $userRole;
    } 
    
    public function setCurrentUserRoleName($userRoleName) {
        error_log('SESSION::setCurrentUser -> variable user = '. $userRoleName);
      
        $_SESSION[$this->sessionRoleName]= $userRoleName;
    }
    public function setCurrentUserState($userState) {
        error_log('SESSION::setCurrentUser -> variable user = '. $userState);
      
        $_SESSION[$this->sessionState]= $userState;
    }


    public function getCurrentUserId() {
        return $_SESSION[$this->sessionId];
    }
    public function getCurrentUserName() {
            return $_SESSION[$this->sessionName];
        }
    public function getCurrentUserRole() {
            return $_SESSION[$this->sessionRole];
        }
    public function getCurrentUserRoleName() {
                return $_SESSION[$this->sessionRoleName];
            }
    public function getCurrentUserN() {
                return $_SESSION[$this->sessionN];
            }
    public function getCurrentUserState() {
                return $_SESSION[$this->sessionState];
            }

    public function CloseSession() {
        session_unset();
        session_destroy();
    }

    public function exists(){
        return isset($_SESSION[$this->sessionId]);
    }

}



?>