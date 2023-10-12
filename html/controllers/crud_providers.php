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
                echo "Proveedor ingresado exitosamente.";
            } else {
                echo "Error al crear el proveedor.";
            }

        }
    }

    public function deleteProvider(){
        if($this->existPOST(['id'])){
            $id = $_POST['id'];
            $providerModel = new ProviderModel();

            if($providerModel->delete($id)){
                echo "Proveedor eliminado exitosamente.";
            }else{
                echo "Error al eliminar el proveedor.";
            }
        }
    }

    public function editProviders(){
        if($this->existPOST(['id', 'providerName', 'CUIT'])){
            $id = $_POST["id"];
            error_log('ESTE ES EL ID QUE RECIBE EN EL CONTROLADOR editProviders');
            error_log($id);
            $providerName = $_POST["providerName"]; 
            $CUIT = $_POST["CUIT"];

            $providerModel = new ProviderModel();
            if ($providerModel->providerNameExists($id, $providerName, $CUIT)) {
                echo "Ya existe ese proveedor.";
                error_log('CONTROLADOR::PROVEEDORES-> EL USUARIO YA EXISTE TE TIRA ERROR');
            } else {
                error_log('CONTROLADOR::PROVEEDORES-> SE GUARDA LO RECIBIDO EN VARIAS VARIABLES');
                $providerModel = new ProviderModel();

                if ($providerModel->update($id, $productName, $stock)) {
                    error_log('CONTROLADOR::PROVEEDORES-> SE ENVÍA');
                } else {
                    echo "Error al actualizar el Producto.";
                    error_log('CONTROLADOR::PROVEEDORES-> HAY ALGÚN ERROR AL ACTUALIZAR EL PROVEEDOR');
                }
            }
        }
    }

}