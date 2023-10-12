<?php
include_once '/var/www/html/libs/imodel.php';
include_once '/var/www/html/libs/model.php';
require_once '/var/www/html/libs/imodel.php';
require_once '/var/www/html/libs/model.php';


class UserModel extends Model{

    private $id;
    private $username;
    private $name;
    private $surname;
    private $dni;
    private $gender;
    private $genderName;
    private $province;
    private $localidad;
    private $street;
    private $bwStreet;
    private $bwStreetTwo;
    private $altura;
    private $ContactCel;
    private $ContactEmail;
    private $password;
    private $role;
    private $roleName;
    private $state;
    private $deleted;

    public function __construct() {
       parent::__construct();
       $this->username = '';
       $this->name = '';
       $this->surname = '';
       $this->dni = '';
       $this->gender = 0;
       $this->genderName = '';
       $this->province = '';
       $this->localidad = '';
       $this->street = '';
       $this->bwStreet = '';
       $this->bwStreetTwo = '';
       $this->altura = '';
       $this->contactCel = '';
       $this->contactEmail = '';
       $this->password = '';
       $this->roleName = '';
       $this->role = 0;
       $this->name = '';
       $this->state = 0;
       $this->deleted = 0;
    }


    public function getAll(){
        $items = [];
        try{
            $query = $this->query('SELECT employees.*, rols.rol_name, genders.gender, contacts.cel, contacts.email
                                    FROM employees
                                    JOIN rols ON employees.id_rol = rols.id_rol
                                    JOIN contacts ON employees.id_contact = contacts.id_contact
                                    JOIN genders ON employees.id_gender = genders.id_gender');
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new UserModel();
                $item->setId($p['id_employee']);
                $item->setUsername($p['username']);
                $item->setName($p['name']);
                $item->setSurname($p['last_name']);
                $item->setDni($p['dni']);
                $item->setGender($p['id_gender']);
                $item->setGenderName($p['gender']);
                $item->setProvince($p['provincia']);
                $item->setLocalidad($p['localidad']);
                $item->setStreet($p['calle']);
                $item->setBwStreet($p['entreCalle1']);
                $item->setBwStreetTwo($p['entreCalle2']);
                $item->setAltura($p['altura']);
                $item->setContactCel($p['cel']);////////////////////
                $item->setContactEmail($p['email']);
                $item->setPassword($p['password']);
                $item->setRole($p['id_rol']);	
                $item->setState($p['state']);
                $item->setRoleName($p['rol_name']);
                $item->setDeleted($p['deleted']);

                array_push($items ,$item);
            }

            return $items;
        }catch(PDOException $e){
            error_log('USERMODEL::getAll-> PDOException '.$e);
        }
    }

    
    public function getAllRole(){
        $items = [];
        try{
            $query = $this->query('SELECT rols.*
                                    FROM rols');
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new UserModel();
                $item->setRole($p['id_rol']);	
                $item->setRoleName($p['rol_name']);
                array_push($items ,$item);
            }

            return $items;
        }catch(PDOException $e){
            error_log('USERMODEL::getAllRole-> PDOException '.$e);
        }
    }

    public function getAllUsernames(){
        $usernames = [];
        try{
            $query = $this->query('SELECT username FROM employees');
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $usernames[] = $row['username'];
            }
            return $usernames;
        }catch(PDOException $e){
            error_log('USERMODEL::getAllUsernames-> PDOException '.$e);
            return [];
        }
    }
    

    public function getAllDni(){
        $dnis = [];
        try{
            $query = $this->query('SELECT dni FROM employees');
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $dnis[] = $row['dni'];
            }
            return $dnis;
        }catch(PDOException $e){
            error_log('USERMODEL::getAllDni-> PDOException '.$e);
            return [];
        }
    }



    public function getAllGender(){
        $items = [];
        try{
            $query = $this->query('SELECT genders.*
                                    FROM genders');
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new UserModel();
                $item->setGender($p['id_gender']);
                $item->setGenderName($p['gender']);
                array_push($items ,$item);
            }

            return $items;
        }catch(PDOException $e){
            error_log('USERMODEL::getAllGender-> PDOException '.$e);
        }
    }

    public function get($id){
        try{
            $query = $this->prepare('SELECT employees.*, rols.rol_name, genders.gender,contacts.cel, contacts.email
                                        FROM employees
                                        JOIN rols ON employees.id_rol = rols.id_rol
                                        JOIN genders ON employees.id_gender = genders.id_gender
                                        JOIN contacts ON employees.id_contact = contacts.id_contact
                                        WHERE employees.id_employee = :id;');
            $query->execute([
                'id' => $id,
            ]);

            $user = $query->fetch(PDO::FETCH_ASSOC);
            if ($user === false) {
                return null; // El usuario no fue encontrado
            }

            $this->setUsername($user['username']);
            $this->setName($user['name']);
            $this->setSurname($user['last_name']);
            $this->setDni($user['dni']);
            $this->setGender($user['id_gender']);
            $this->setGenderName($user['gender']);
            $this->setProvince($user['provincia']);
            $this->setLocalidad($user['localidad']);
            $this->setStreet($user['calle']);
            $this->setBwStreet($user['entreCalle1']);
            $this->setBwStreetTwo($user['entreCalle2']);
            $this->setAltura($user['altura']);
            $this->setContactCel($user['cel']);
            $this->setContactEmail($user['email']);
            $this->setPassword($user['password']);
            $this->setRole($user['id_rol']);	
            $this->setRoleName($user['rol_name']);	
            $this->setState($user['state']);
            $this->setId($user['id_employee']);
            $this->setName($user['name']);
            $this->setDeleted($user['deleted']);

            
            return $this;
        }catch(PDOException $e){
            error_log('USERMODEL::getId-> PDOException '.$e);
        }
    }

    
    public function delete($id, $deleted) {
        try {
            $query = $this->prepare('UPDATE employees SET deleted = :deleted WHERE id_employee = :id');
            $query->execute([
                'deleted' => $deleted,
                'id' => $id
            ]);
            return true;
        } catch(PDOException $e) {
            error_log('USERMODEL::delete-> PDOException '.$e);
            return false;
        }
    }

    
    public function usernameExists($id, $username, $dni) {
        try {
            $query = $this->prepare("SELECT COUNT(*) as count FROM employees WHERE (username = :username OR dni = :dni) AND id_employee != :id");
            $query->execute([':username' => $username, ':id' => $id, ':dni' => $dni]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log('Error: ' . $e);
            return false;  
        }
    }
    
    

    public function update($id, $username, $name, $surname, $dni, $gender, $province, $localidad, $street, 
                            $bwStreet, $bwStreetTwo, $altura, $cel, $password, $email, $role, $state){
        try{
            $cont = 0; // Define $cont como 0 inicialmente

            if (empty($_POST['password'])) {
                //El campo de password está vacío
            } else {
                // Hashear el password antes de guardarlo en la base de datos
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $cont = 1;
            }
            
            $query = $this->prepare('UPDATE employees 
            INNER JOIN contacts ON employees.id_contact = contacts.id_contact 
            SET username = :username, name = :name, last_name = :surname,
            dni = :dni, id_gender = :gender, provincia = :province, localidad = :localidad, 
            calle = :street, entreCalle1 = :bwStreet, entreCalle2 = :bwStreetTwo, 
            altura = :altura, cel = :cel, email = :email, id_rol = :id_rol, state = :state ' . ($cont == 1 ? ', password = :password ' : '') . 'WHERE id_employee = :id');
            
            $params = [
                'id' => $id,
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
                'cel' => $cel,
                'email' => $email,
                'id_rol' => $role,
                'state' => $state,
            ];
            
            if ($cont == 1) {
                $params['password'] = $hashedPassword;
            }
            
            $query->execute($params);
        

            return true;
        }catch(PDOException $e){
            error_log('USERMODEL::update-> PDOException '.$e);

            return false;
        }
    }

 
public function createUser($username, $name, $surname, $dni, $gender, $province, $localidad, $street, 
                            $bwStreet, $bwStreetTwo, $altura, $cel, $email, $rol, $password) {
    try {
        $database = new Database();
        $pdo = $database->connect();
        $pdo->beginTransaction();

        $queryContacts = $pdo->prepare('INSERT INTO contacts(email, cel) VALUES (:email, :cel)');
        
        $queryContacts->execute([
            'email' => $email,
            'cel' => $cel,
        ]);

        // Hashear el password antes de guardarlo en la base de datos
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $queryEmployees = $pdo->prepare('INSERT INTO employees(username, name, last_name, dni, id_gender, provincia,
        localidad, calle, entreCalle1, entreCalle2, altura, id_rol, id_contact, state, deleted, password) 
        VALUES (:username, :name, :surname, :dni, :gender, :province, :localidad, :street, 
                :bwStreet, :bwStreetTwo, :altura, :rol, LAST_INSERT_ID(), :state, :deleted, :password)');

            $state = 0;
            $deleted = 1;

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
            'password' => $hashedPassword,
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






    public function from($array){
        $this->id = $array['id_employee'];
        $this->username = $array['username'];
        $this->name    = $array['name'];
        $this->surname    = $array['last_name'];
        $this->dni    = $array['dni'];
        $this->gender    = $array['id_gender'];
        $this->genderName    = $array['gender'];
        $this->province    = $array['provincia'];
        $this->localidad    = $array['localidad'];
        $this->street    = $array['calle'];
        $this->bwStret    = $array['entreCalle'];
        $this->bwStreetTwo    = $array['entreCalle2'];
        $this->altura    = $array['altura'];
        $this->contactCel    = $array['cel'];
        $this->contactEmail    = $array['mail'];
        $this->password = $array['password'];
        $this->role     = $array['id_rol'];
        $this->roleName     = $array['rol_name'];
        $this->state     = $array['state'];
        $this->name    = $array['name'];
        $this->deleted    = $array['deleted'];
    }

    //verifica si existe usernamame en la base de datos
    public function exists($username){
        try{
            $query = $this->prepare('SELECT username FROM employees WHERE username = :username');
            $query->execute(['username' => $username]);
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }catch(PDOExeception $e){
            error_log('USERMODEL::exists-> PDOException '.$e);

            return false;
        }
    }

    public function comparePassword($password, $id){
        try{
            $user = $this->get($id);

            return password_verify($password, $user->getPassword());

        }catch(PDOException $e){
            error_log('USERMODEL::comparePassword-> PDOException '.$e);
            return false;
        }
    }

    private function getHashedPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
    public function setId($id){             $this->id = $id;  }
    public function setUsername($username){ $this->username = $username; }
    public function setName($name){ $this->name = $name; }
    public function setSurname($surname){ $this->surname = $surname; }
    public function setDni($dni){ $this->dni = $dni; }
    public function setGender($gender){ $this->gender = $gender; }
    public function setGenderName($genderName){ $this->genderName = $genderName; }
    public function setProvince($province){ $this->province = $province; }
    public function setLocalidad($localidad){ $this->localidad = $localidad; }
    public function setStreet($street){ $this->street = $street; }
    public function setBwStreet($bwStreet){ $this->bwStreet = $bwStreet; }
    public function setBwStreetTwo($bwStreetTwo){ $this->bwStreetTwo = $bwStreetTwo; }
    public function setAltura($altura){ $this->altura = $altura; }
    public function setContactCel($contactCel){ $this->contactCel = $contactCel; }
    public function setContactEmail($contactEmail){ $this->contactEmail = $contactEmail; }
    public function setPassword($password){ 
        $this->password = $this->getHashedPassword($password);
     }
    public function setRole($role){         $this->role = $role; }
    public function setRoleName($roleName){         $this->roleName = $roleName; }
    public function setState($state){         $this->state = $state; }
    public function setDeleted($deleted){         $this->deleted = $deleted; }

    public function getId(){                return $this->id;}
    public function getUsername(){          return $this->username;}
    public function getName(){          return $this->name;}
    public function getSurname(){          return $this->surname;}
    public function getDni(){                return $this->dni;}
    public function getGender(){                return $this->gender;}
    public function getGenderName(){                return $this->genderName;}
    public function getProvince(){                return $this->province;}
    public function getLocalidad(){                return $this->localidad;}
    public function getStreet(){                return $this->street;}
    public function getBwStreet(){                return $this->bwStreet;}
    public function getBwStreetTwo(){                return $this->bwStreetTwo;}
    public function getAltura(){                return $this->altura;}
    public function getContactCel(){                return $this->contactCel;}
    public function getContactEmail(){                return $this->contactEmail;}
    public function getPassword(){          return $this->password;}
    public function getState(){              return $this->state;}
    public function getRole(){              return $this->role;}
    public function getRoleName(){              return $this->roleName;}
    public function getDeleted(){              return $this->deleted;}

}
?>