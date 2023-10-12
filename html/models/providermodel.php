<?php
include_once '/var/www/html/libs/imodel.php';
include_once '/var/www/html/libs/model.php';
require_once '/var/www/html/libs/imodel.php';
require_once '/var/www/html/libs/model.php';

class ProviderModel extends Model{
    private $id;
    private $razonSocial;
    private $cuit;
    
    public function __construct() {
        parent::__construct();
        $this->id = 0;
        $this->razonSocial = '';
        $this->cuit = '';
    }

    public function getAll(){
        $items = [];
        try{
        $query = $this->query('SELECT id_provedor, razon_social, CUIT FROM provedores');
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new ProviderModel();
                $item->setId($p['id_provedor']);
                $item->setRazonSocial($p['razon_social']);
                $item->setCuit($p['CUIT']);

                array_push($items ,$item);
            }

            return $items;
        }catch(PDOException $e){
            error_log('PROVIDERSMODEL::getAll-> PDOException '.$e);
        }
     }

     public function get($id){
        try{
            $query = $this->prepare('SELECT * FROM provedores WHERE provedores.id_provedor = :id;');
            $query->execute([
                'id' => $id,
            ]);

            $provider = $query->fetch(PDO::FETCH_ASSOC);
            if ($provider === false) {
                return null; // El producto no fue encontrado
            }
            $this->setRazonSocial($provider['razon_social']);
            $this->setCuit($provider['CUIT']);
            return $this;

        }catch(PDOException $e){
            error_log('PROVIDERSMODEL::getId-> PDOException '.$e);
            return null;
        }
    }

    public function createProvider($razonSocial, $cuit)
    {
        try{
            $query = $this->prepare('INSERT INTO provedores (razon_social, CUIT) VALUES (:razonSocial, :cuit)');
            $query->execute([
                'razonSocial' => $razonSocial,
                'cuit' => $cuit
            ]);
            
            return true;
        }
        catch(PDOException $e){
            error_log('PRODUCTSMODEL::createProvider-> PDOException ' . $e);
            return false;
        }
    }

    public function delete($id){
        try {
            $query = $this->prepare('DELETE FROM provedores WHERE id_provedor = :id');
            $query->execute([
                'id' => $id,
            ]);
            return true;
        } catch(PDOException $e) {
            error_log('PRODUCTSMODEL::delete-> PDOException '.$e);
            return false;
        }
    }



     public function setId($id){             $this->id = $id;  }
     public function setCuit($cuit){             $this->cuit = $cuit;  }
     public function setRazonSocial($razonSocial){             $this->razonSocial = $razonSocial;  }

     public function getId(){                return $this->id;}
     public function getRazonSocial(){                return $this->razonSocial;}
     public function getCuit(){                return $this->cuit;}
}
?>