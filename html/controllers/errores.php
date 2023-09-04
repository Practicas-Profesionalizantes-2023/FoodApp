<?php

class Errores extends Controller{
    function __construct(){
        parent::__construct();
        error_log('ERROR-> inicio de 404');

    }

    function render(){
        $this->view->render('errores/index');
    }
}

?>