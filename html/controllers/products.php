<?php

require_once "/var/www/html/models/salesmodel.php";

class Products {

    public function __construct() {
    
    }

    public function render() {
        error_log('DASHBOARD -> CARGA EL INDEX DASHBOARD');
    }

    /*===================================================================
    LISTAR NOMBRE DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    ====================================================================*/
    public function ctrListarNombreProductos() {
        error_log('Products::ctrListarNombreProductos');
        $producto = Salesmodel::mdlListarNombreProductos();

        return $producto;
    }
}

?>
