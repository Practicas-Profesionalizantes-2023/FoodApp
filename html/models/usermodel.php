<?php

class UserModel extends Model implements IModel{

    private $id_user;
    private $username;
    private $password;
    private $role;
    private $tate;

    public function __construct() {
       parent::__construct();
       $this->username = '';
       $this->password = '';
       $this->role = '';
       $this->name = '';
       $this->state = 0;

    }
    public function save(){
        try{
            $query-> $this->prepare('INSERT users(username, password, role, state) VALUES (:username, :password, :role, :state)');
            $query->execute([
                'username' => $this->username,
                'password' => $this->password,
                'role' => $this->role,
                'name' => $this->name
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
            $query = $this->query('SELECT * FROM users');
            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new UserModel();
                $item->setId($p['id_user']);
                $item->setUsername($p['username']);
                $item->setPassword($p['password']);
                $item->setRole($p['role']);	
                $item->setName($p['name']);

                array_push($items ,$item);
            }

            return $items;
        }catch(PDOException $e){
            error_log('USERMODEL::getAll-> PDOException '.$e);
        }
    }


    public function get($id){
        try{
            $query = $this->prepare('SELECT * FROM users WHERE id = :id');
            $query->execute([
                'id' => $id,
            ]);

            $user = $query->fetch(PDO::FETCH_ASSOC);
            if ($user === false) {
                return null; // El usuario no fue encontrado
            }

            $this->setUsername($user['username']);
            $this->setPassword($user['password']);
            $this->setRole($user['role']);	
            $this->setName($user['name']);
            $this->setId($user['id']);
            
            return $this;
        }catch(PDOException $e){
            error_log('USERMODEL::getId-> PDOException '.$e);
        }
    }
    public function delete($id){
        try{
            $query = $this->prepare('DELETE * FROM users WHERE id = :id');
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
            $query = $this->prepare('UPDATE users SET username = :username, password = :password, budget = :budget, photo = :photo, name = :name WHERE id_user = :id');
            $query->execute([
                'id_user' => $this->$id,
                'username' => $this->$username,
                'password' => $this->$password,
                'name' => $this->$name,
            ]);

            return true;
        }catch(PDOException $e){
            error_log('USERMODEL::update-> PDOException '.$e);

            return false;
        }
    }
    public function from($array){
        $this->id = $array['id_user'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->role     = $array['role'];
        $this->name     = $array['name'];
    }

    //verifica si existe usernamame en la base de datos
    public function exists($username){
        try{
            $query = $this->prepare('SELECT username FROM users WHERE username = :username');
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
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }
    public function setId($id){             $this->id = $id;  }
    public function setUsername($username){ $this->username = $username; }
    public function setPassword($password){ 
        $this->password = $this->getHashedPassword($password);
     }
    public function setRole($role){         $this->role = $role; }
    public function setName($name){         $this->name = $name; }

    public function getId(){                return $this->id;}
    public function getUsername(){          return $this->username;}
    public function getPassword(){          return $this->password;}
    public function getName(){              return $this->name;}
    public function getRole(){              return $this->role;}

}
?>