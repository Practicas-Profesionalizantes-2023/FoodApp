<?php

class Login extends SessionController {
    function __construct(){
        parent::__construct();
        error_log('Login-> inicio de login');

    }

    function render(){
        error_log('Login-> CARGA EL INDEX LOGIN');
        $this->view->render('login/index');
    }
}

?>