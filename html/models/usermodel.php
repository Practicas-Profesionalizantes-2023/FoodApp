<?php

class UserModel extends Model {

    private $id;
    private $username;
    private $password;
    private $role;
    private $roleName;
    private $state;
   

    public function __construct() {
       parent::__construct();
       $this->username = '';
       $this->password = '';
       $this->roleName = '';
       $this->role = 0;
       $this->name = '';
       $this->state = 0;

    }
    public function save(){
        try{
            $query-> $this->prepare('INSERT employees(username, password, id_rol, state) VALUES (:username, :password, :role, :state)');
            $query->execute([
                'username' => $this->username,
                'password' => $this->password,
                'id_rol' => $this->role,
                'state' => $this->state
            ]);
            return true;

        }catch(PDOException $e){
            error_log('USERMODEL::save-> PDOException '.$e);
            return false;
        };
    }
    public function getAll(){
        $items = [];
        try{
            $query = $this->query('SELECT employees.*, rols.rol_name
                                    FROM employees
                                    JOIN rols ON employees.id_rol = rols.id_rol;');
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new UserModel();
                $item->setId($p['id_employee']);
                $item->setUsername($p['username']);
                $item->setPassword($p['password']);
                $item->setRole($p['id_rol']);	
                $item->setState($p['state']);
                $item->setRoleName($p['rol_name']);

                array_push($items ,$item);
            }

            return $items;
        }catch(PDOException $e){
            error_log('USERMODEL::getAll-> PDOException '.$e);
        }
    }


    public function get($id){
        try{
            $query = $this->prepare('SELECT employees.*, rols.rol_name
                                        FROM employees
                                        JOIN rols ON employees.id_rol = rols.id_rol
                                        WHERE employees.id_employee = :id;');
            $query->execute([
                'id' => $id,
            ]);

            $user = $query->fetch(PDO::FETCH_ASSOC);
            if ($user === false) {
                return null; // El usuario no fue encontrado
            }

            $this->setUsername($user['username']);
            $this->setPassword($user['password']);
            $this->setRole($user['id_rol']);	
            $this->setRoleName($user['rol_name']);	
            $this->setState($user['state']);
            $this->setId($user['id_employee']);
            $this->setName($user['name']);
            
            return $this;
        }catch(PDOException $e){
            error_log('USERMODEL::getId-> PDOException '.$e);
        }
    }
    public function delete($id){
        try{
            $query = $this->prepare('DELETE * FROM employees WHERE id_employee = :id');
            $query->execute([
                'id' => $id,
            ]);
            return true;
        }catch(PDOException $e){
            error_log('USERMODEL::delete-> PDOException '.$e);
            return false;
        }
    }
    public function update(){
        try{
            $query = $this->prepare('UPDATE employees SET username = :username, password = :password, id_rol = :role, state = :state WHERE id_user = :id');
            $query->execute([
                'id_employee' => $this->$id,
                'username' => $this->$username,
                'id_rol' => $this->$role,
                'password' => $this->$password,
                'state' => $this->$state,
            ]);

            return true;
        }catch(PDOException $e){
            error_log('USERMODEL::update-> PDOException '.$e);

            return false;
        }
    }
    public function from($array){
        $this->id = $array['id_employee'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->role     = $array['id_rol'];
        $this->roleName     = $array['rol_name'];
        $this->state     = $array['state'];
        $this->name    = $array['name'];
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
        return password_hash($password);
    }
    public function setId($id){             $this->id = $id;  }
    public function setUsername($username){ $this->username = $username; }
    public function setName($name){ $this->name = $name; }
    public function setPassword($password){ 
        $this->password = $this->getHashedPassword($password);
     }
    public function setRole($role){         $this->role = $role; }
    public function setRoleName($roleName){         $this->roleName = $roleName; }
    public function setState($state){         $this->state = $state; }

    public function getId(){                return $this->id;}
    public function getUsername(){          return $this->username;}
    public function getName(){          return $this->name;}
    public function getPassword(){          return $this->password;}
    public function getState(){              return $this->state;}
    public function getRole(){              return $this->role;}
    public function getRoleName(){              return $this->roleName;}

}
?>
