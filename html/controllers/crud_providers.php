<?php
include_once "/var/www/html/models/providermodel.php";

class Crud_providers extends SessionController {
    function __construct(){
        parent::__construct();
        error_log('DASHBOARD-> inicio de dashboard');

    }

    function render(){
        error_log('DASHBOARD-> CARGA EL INDEX DASHBOARD');
        $this->view->render('providers/crud_providers');
    }

    public function createProvider(){
        if($this->existPOST(['providerName', 'CUIT'])){
            $providerName = $_POST["providerName"];
            $CUIT = $_POST["CUIT"];

            $providerModel = new ProviderModel();
            if ($providerModel->createProvider($providerName, $CUIT)) {
                echo "Producto ingresado exitosamente.";
            } else {
                echo "Error al crear el producto.";
            }

        }
    }

}