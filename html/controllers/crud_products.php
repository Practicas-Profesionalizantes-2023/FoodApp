<?php
include_once "/var/www/html/models/productsmodel.php";

class Crud_products extends SessionController {
    function __construct(){
        parent::__construct();
        error_log('DASHBOARD-> inicio de dashboard');

    }

    function render(){
        error_log('DASHBOARD-> CARGA EL INDEX DASHBOARD');
        $this->view->render('products/crud_products');
    }

    public function deleteProduct(){
        if($this->existPOST(['id'])){
            $id = $_POST['id'];
            $productsModel = new ProductsModel();

            if($productsModel->delete($id)){
                echo "Producto eliminado exitosamente.";
            }else{
                echo "Error al eliminar el producto.";
            }
        }
    }

    public function createProduct(){
        if($this->existPOST(['productname', 'stock', 'price','providerName', 'stockAlert'])){
            $productName = $_POST["productname"];
            $stock = $_POST["stock"];
            $price = $_POST["price"];
            $providerName = $_POST["providerName"];
            $stockAlert = $_POST["stockAlert"];

            $productsModel = new ProductsModel();
            if ($productsModel->createProduct($productName, $stock, $price, $providerName, $stockAlert)) {
                echo "Producto ingresado exitosamente.";
            } else {
                echo "Error al crear el producto.";
            }

        }
    }

    public function editProducts(){
        if($this->existPOST(['id', 'productName', 'stock', 'price','providerName', 'stockAlert'])){
            $id = $_POST["id"];
            error_log('ESTE ES EL ID QUE RECIBE EN EL CONTROLADOR editProducts');
            error_log($id);
            $name = $_POST["productName"]; 
            error_log('ACÁ ESTOY. SI ESTOY LLAMA AL CONTROLADOR');

            // Verificar si el nuevo nombre de usuario ya existe en la base de datos
            $productsModel = new ProductsModel();
            if ($productsModel->productNameExists($id, $name)) {
                echo "Ya existe ese producto.";
                error_log('CONTROLADOR::PRODUCTOS-> EL USUARIO YA EXISTE TE TIRA ERROR');
            } else {
                // Resto de tus variables
                $productName = $_POST["productName"];
                error_log($productName);
                $stock = $_POST["stock"];
                error_log($stock);
                $price = $_POST["price"];
                error_log($price);
                $provider = $_POST["providerName"];
                error_log($provider);
                $stockAlert = $_POST["stockAlert"];
                error_log($stockAlert);

                error_log('CONTROLADOR::PRODUCTOS-> SE GUARDA LO RECIBIDO EN VARIAS VARIABLES');

                $productsModel = new ProductsModel();
                if ($productsModel->update($id, $productName, $stock, $price, $provider, $stockAlert)) {
                    error_log('CONTROLADOR::PRODUCTOS-> SE ENVÍA');
                } else {
                    echo "Error al actualizar el Producto.";
                    error_log('CONTROLADOR::PRODUCTOS-> HAY ALGÚN ERROR AL ACTUALIZAR EL PRODUCTO');
                }
            }
        }
    }

}//Cierra clase