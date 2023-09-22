<?php
require_once 'clases/session.php';

class SessionController extends Controller{

    private $userSession;
    private $username;
    private $userid;
    
    private $session;
    private $sites;

    private $user;


    public function __construct(){
        parent::__construct();
        $this->init();

    }

    public function getUserSession(){
        return $this->userSession;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getUserId(){
        return $this->userid;
    }

    function init(){
        $this->session = new Session();

        $json = $this->getJSONFileConfig();

        $this->sites = $json['sites'];
        $this->defaultSites = $json['default-sites'];

        $this->validateSession();
    }

    private function getJSONFileConfig(){
        $string = file_get_contents('/var/www/html/config/access.json');
        $json = json_decode($string, true);

        return $json;
    }

    public function validateSession(){
        error_log('SESSIONCONTROLLER::validateSession');

         //si existe la session
        if($this->existsSession()){
            error_log("sessionController::validateSession():entra al if");
           $role = $this->getUserSessionData()->getRole();
           error_log("sessionController::validateSession(): username:" . $this->user->getUsername() . " - role: " . $this->user->getRole());
           //si a la pagina al entrar es public
           if($this->isPublic()){
                $this->redirectDefaultSiteByRole($role);
           }else{
            if($this->isAuthorized($role)){
                //si el usuario esta autorizado lo dejo pasar

            }else{
                $this->redirectDefaultSiteByRole($role);
            }
           }
        }else{
            //no existe la session
            if($this->isPublic()){
                // no pasa nada, lo dejo pasar
            }else{
                error_log('SessionController::validateSession() redirect al login');
                header('location: '. constant('URL'). '');
            }

        }
    }

    function existsSession(){
        
        if(!$this->session->exists()) return false;     
        error_log('SESSIONCONTROLLER::existsSession -> exists');
        error_log('SESSIONCONTROLLER::existsSession -> verificando si existe session ' .$this->session->getCurrentUserName());
        if($this->session->getCurrentUserId() == NULL) return false;

        $userid = $this->session->getCurrentUserId();
        error_log('SESSIONCONTROLLER::existsSession -> verificando si existe session '. $userid);
        if($userid) return true;

        return false;
    }

    public function getUserSessionData(){
        $id = $this->session->getCurrentUserId();
        require_once '/var/www/html/models/usermodel.php';
        $this->user = new UserModel();
        $this->user->get($id);

        error_log('SESSIONCONTROLLER::getUserSession -> '. $this->getUsername());

        return $this->user;
    }

    private function isPublic(){
        $currentURL = $this->getCurrentPage();
        error_log("sessionController::isPublic(): currentURL => " . $currentURL);
        $currentURL = preg_replace( "/\?.*/", "", $currentURL); //omitir get info
        for($i = 0; $i < sizeof($this->sites); $i++){
            if($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['access'] === 'public'){
                return true;
            }
        }
        return false;
    }

    function getCurrentPage(){
        $actual_link = trim("$_SERVER[REQUEST_URI]");
        $url = explode('/', $actual_link);
        error_log("sessionController::getCurrentPage(): actualLink =>" . $actual_link . ", url => " . $url[1]);
        return $url[1];
    }

    private function redirectDefaultSiteByRole($role){
        $url = '';
        error_log('sessionController::redirectDefaultSiteByRole-> entra a byrole');
        for($i = 0; $i < sizeof($this->sites); $i++){
            if($this->sites[$i]['role'] == $role){
                $url = $this->sites[$i]['site'];
                break;
            }
        }
        header('Location: '. constant('URL').$url);
    }

    private function isAuthorized($role){
        $currentURL = $this->getCurrentPage();
        $currentURL = preg_replace("/\?.*/", "", $currentURL);
        
        for($i = 0; $i < sizeof($this->sites); $i++) {
            if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['role'] == $role){
                return true;
            }
        }

        return false;
    }

    function initialize($user){
        error_log('SessionController::initialize-> manda al getCurrentUser');
        $this->session->setCurrentUserId($user->getId());
        $this->session->setCurrentUserName($user->getUsername());
        $this->session->setCurrentUserN($user->getName());
        $this->session->setCurrentUserRole($user->getRole());
        $this->session->setCurrentUserRoleName($user->getRoleName());
        $this->session->setCurrentUserState($user->getState());
        error_log('SessionController::initialize-> manda a la funcion authorizeAccess');

        $this->authorizeAccess($user->getRole());
    }

    function authorizeAccess($role){
        error_log('SessionController::authorizeAccess-> variables role= '.$role);

        switch ($role){
            case '1':
                    $this->redirect($this->defaultSites['user'],[]);
                break;
            case '2':
                    $this->redirect($this->defaultSites['admin'],[]);
                break;
        }
    }

    function logout() {
        $this->session->closeSession();
    }
}


?>