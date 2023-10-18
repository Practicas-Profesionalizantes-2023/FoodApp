<?php

class Controller{

    function __construct(){
        $this->view = new View();
    }

    function loadModel($model){
        $url = 'models/' . $model. 'model.php';
        if(file_exists($url)){
            require_once $url;

            $modelName = $model.'Model';
            $this->model =new $modelName();
        }
    }

    function existPOST($params){
        foreach ($params as $param) {
            if(!isset($_POST[$param])){
                error_log("ExistPOST: No existe el parametro $param" );
                return false;
            }
        }
        error_log( "ExistPOST: Existen parámetros" );
        return true;
    }

    function existGET($params){
        foreach($params as $param){
            if(!isset($_GET[$param])){
                error_log('CONTROLLER::existGET => no exite el parametro ' . $param);
                return false;
            }
        }

        return true;
    }

    function getGet($name){
        return $_GET[$name];
    }
    function getPOST($name){
        return $_POST[$name];
    }

    function redirect($url, $mensajes = []){
        error_log('Controller::redirect-> entra a redirect y la url es => ' . $url);
        // error_log('Controller::redirect-> entra a redirect y la mensajes es => ' . $mensajes);

        $data = [];
        $params = '';

        foreach ($mensajes as $key => $value) {
            array_push($data, $key . '=' . $value);
        }
        $params = join('&', $data);

        if($params != ''){
            $params = '?' . $params;
        }
        error_log('Controller::redirect-> params => ' . $params);
        header('location: ' . constant('URL') . $url . $params);
    }
}

?>