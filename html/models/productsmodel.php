<?php
include_once '/var/www/html/libs/imodel.php';
include_once '/var/www/html/libs/model.php';
require_once '/var/www/html/libs/imodel.php';
require_once '/var/www/html/libs/model.php';

class ProductsModel extends Model{
    private $id;
    private $itemName;
    private $stock;
    private $price;
    private $idProvider;
    private $stockAlert;
    private $razonSocial;
    private $cuit;

    public function __construct() {
        parent::__construct();
        $this->id = 0;
        $this->itemName = '';
        $this->stock = 0;
        $this->price = 0.0;
        $this->idProvider = 0;
        $this->stockAlert = 0;
        $this->razonSocial = '';
        $this->cuit = '';
    }


     public function getAll(){
        $items = [];
        try{
        $query = $this->query('SELECT products.*, provedores.id_provedor
                                    FROM products
                                    JOIN provedores ON products.id_provedor = provedores.id_provedor');
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new ProductsModel();
                $item->setId($p['id_product']);
                $item->setItemName($p['name_iten']);
                $item->setStock($p['stock']);
                $item->setPrice($p['precio_unitario']);
                $item->setIdProvider($p['id_provedor']);
                $item->setStockAlert($p['alerta_stock']);
                $item->setRazonSocial($p['razon_social']);
                $item->setCuit($p['CUIT']);


                array_push($items ,$item);
            }

            return $items;
        }catch(PDOException $e){
            error_log('PRODUCTSMODEL::getAll-> PDOException '.$e);
        }
     }

     public function delete($id){
        try {
            $query = $this->prepare('DELETE FROM products WHERE id_product = :id');
            $query->execute([
                'id' => $id,
            ]);
            return true;
        } catch(PDOException $e) {
            error_log('PRODUCTSMODEL::delete-> PDOException '.$e);
            return false;
        }
    }
    

    
    public function createProduct($username, $name, $surname, $dni, $gender, $province, $localidad, $street, 
                                $bwStreet, $bwStreetTwo, $altura, $cel, $email, $rol, $state, $deleted, $password) {
        try {
            $database = new Database();
            $pdo = $database->connect();
            $pdo->beginTransaction();

            // Consulta para insertar datos en la tabla contacts
            $queryContacts = $pdo->prepare('INSERT INTO contacts(email, cel) VALUES (:email, :cel)');
            
            $queryContacts->execute([
                'email' => $email,
                'cel' => $cel,
            ]);

            // Hashear el password antes de guardarlo en la base de datos
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Consulta para insertar datos en la tabla employees
            $queryEmployees = $pdo->prepare('INSERT INTO employees(username, name, last_name, dni, id_gender, provincia,
            localidad, calle, entreCalle1, entreCalle2, altura, id_rol, id_contact, state, deleted, password) 
            VALUES (:username, :name, :surname, :dni, :gender, :province, :localidad, :street, 
                    :bwStreet, :bwStreetTwo, :altura, :rol, LAST_INSERT_ID(), :state, :deleted, :password)');

            $queryEmployees->execute([
                'username' => $username,
                'name' => $name,
                'surname' => $surname,
                'dni' => $dni,
                'gender' => $gender,
                'province' => $province,
                'localidad' => $localidad,
                'street' => $street,
                'bwStreet' => $bwStreet,
                'bwStreetTwo' => $bwStreetTwo,
                'altura' => $altura,
                'rol' => $rol,
                'state' => $state,
                'deleted' => $deleted,
                'password' => $hashedPassword, // Guardamos el password hasheado
            ]);

            // Confirmar la transacción
            $pdo->commit();

            return true;
        } catch (PDOException $e) {
            // Revertir la transacción en caso de error
            $pdo->rollBack();
            error_log('USERMODEL::createUser-> PDOException ' . $e);

            return false;
        }
    }
    



     public function setId($id){             $this->id = $id;  }
     public function setItemName($itemName){             $this->itemName = $itemName;  }
     public function setStock($stock){             $this->stock = $stock;  }
     public function setPrice($price){             $this->price = $price;  }
     public function setIdProvider($idProvider){             $this->idProvider = $idProvider;  }
     public function setStockAlert($stockAlert){             $this->stockAlert = $stockAlert;  }
     public function setRazonSocial($razonSocial){             $this->razonSocial = $razonSocial;  }
     public function setCuit($cuit){             $this->cuit = $cuit;  }

     public function getId(){                return $this->id;}
     public function getItemName(){                return $this->itemName;}
     public function getStock(){                return $this->stock;}
     public function getPrice(){                return $this->price;}
     public function getIdProvider(){                return $this->idProvider;}
     public function getStockAlert(){                return $this->stockAlert;}
     public function getRazonSocial(){                return $this->razonSociial;}
     public function getCuit(){                return $this->cuit;}

}//cierra Clase

?>