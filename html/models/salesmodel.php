<?php

require_once './libs/database.php';

class Salesmodel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*===================================================================
    LISTAR NOMBRE DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    ====================================================================*/
    public static function mdlListarNombreProductos()
    {
        $db = new Database(); // Supongo que tienes una clase Database para manejar la conexión a la base de datos.

        $query = $db->connect()->prepare(
                                        "SELECT Concat(
                                            m.name_menu,' / ',
                                            m.precio, ' / Stock: ',
                                            p.stock)  as descripcion_producto
                                        FROM menu m 
                                        INNER JOIN menu_ingredientes mi ON m.id_menu = mi.id_menu
                                        INNER JOIN products p ON mi.id_product = p.id_product"
                                    );

        $query->execute();

        return $query->fetchAll();
    }
}
