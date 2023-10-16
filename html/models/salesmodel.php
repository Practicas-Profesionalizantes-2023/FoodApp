<?php

require_once '../libs/database.php';
include_once '/var/www/html/libs/model.php';
require_once '../libs/conection.php';
class SalesModel {

    function __constructor(){
       
    }


    /*===================================================================
    LISTAR NOMBRE DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    ====================================================================*/
    public function mdlListProduct()
    {
       
        $query = Conection::connect()->prepare(
                                        "SELECT Concat(								
    										m.id_menu,' / ',
                                            m.name_menu,' / ',
                                            m.precio, ' / Stock: ',
                                            p.stock)  as descripcion_producto
                                        FROM menu m 
                                        INNER JOIN menu_ingredientes mi ON m.id_menu = mi.id_menu
                                        INNER JOIN products p ON mi.id_product = p.id_product");

        $query->execute();

        return $query->fetchAll();
    }
/*===================================================================
    buscar menu para agregar a la tabla
    ====================================================================*/
    public function mdShearchMenuId($id_menu)
    {
       
        $query = Conection::connect()->prepare(
                                        "SELECT id_menu, name_menu, detalle, precio, c.categoria_name,
                                         CONCAT('$ ',CONVERT(ROUND(1*precio,2), CHAR)) as total
                                        FROM menu p
                                        JOIN categorias c ON c.id_categoria = p.id_categoria
                                        WHERE id_menu = :id_menu");
        
        $query->bindParam(':id_menu', $id_menu, PDO::PARAM_STR);

        $query->execute();

        return $query->fetch(PDO::FETCH_OBJ);
    }

    /*===================================================================
    buscar menu para agregar a la tabla
    ====================================================================*/
    public function mdVerifyStock($id_menu, $cantidad)
    {
       
        $query = Conection::connect()->prepare(
                                        " SELECT   count(*) as existe
                                        FROM menu m
                                        JOIN menu_ingredientes i ON i.id_menu = m.id_menu
                                        join products p ON i.id_product = p.id_product
                                        WHERE m.id_menu = :id_menu
                                        AND p.stock >= :cantidad");
        
        $query->bindParam(':id_menu', $id_menu, PDO::PARAM_INT);
        $query->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $query->execute();
        
        return $query->fetch(PDO::FETCH_OBJ);
    }
    /*===================================================================
    buscar menu para agregar a la tabla
    ====================================================================*/
    public function mdlRegisterVenta($array, $totalVenta, $payment)
    {
      
        $allInsertionsSuccessful = true; // Variable para rastrear el estado de las inserciones
        
        foreach ($array as $item) {
            $list = explode(',', $item);
        
            if (count($list) === 3) {
                $id_menu = $list[0];
                $cantidad = $list[1];
                $totalVenta = $list[2];
        
                // Preparar la sentencia
                $query = Conection::connect()->prepare(
                    "INSERT INTO detalle_ventas (id_menu, cantidad, precio_total, id_payment)
                    VALUES (:id_menu, :cantidad, :totalVenta, :id_payment)"
                );
        
                $id_payment = $payment; // Asumiendo que $payment contiene el valor que deseas usar
        
                $query->bindParam(':id_menu', $id_menu, PDO::PARAM_INT);
                $query->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $query->bindParam(':totalVenta', $totalVenta, PDO::PARAM_INT);
                $query->bindParam(':id_payment', $id_payment, PDO::PARAM_INT);
        
                if (!$query->execute()) {
                    // Si una inserción falla, establece la variable $allInsertionsSuccessful a false
                    $allInsertionsSuccessful = false;
                    break; // Salir del bucle si hay una inserción fallida
                }
            } else {
                // Si la cadena no se dividió en tres partes, establece la variable $allInsertionsSuccessful a false
                $allInsertionsSuccessful = false;
                break; // Salir del bucle si hay un error
            }
        }
        
        if ($allInsertionsSuccessful) {
            $response = "Venta Registrada con EXITO";
        } else {
            $response = "ERROR AL REGISTRAR VENTA";
        }
        
        return $response;
        

    }


   

}
