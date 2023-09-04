<?php

require_once ('usermodel.php');
class LoginModel extends Model{

    function __constructor(){
        parent::__construct();
    }

    function login($username, $password){//nuevo
        error_log('LoginModel::login->entre a login');
        try {
            $query = $this->prepare('SELECT * FROM users WHERE username = :username');
            $query->execute(['username' => $username]);
            
            if($query->rowCount() == 1){
                $item = $query->fetch(PDO::FETCH_ASSOC);
                error_log('LoginModel::login->eexiste solo un username');
                $user = new UserModel();
                $user->from($item);

                if(password_verify($password, $user->getPassword())){
                    error_log('LoginModel::login-> contraseña correcta');
                    return $user;
                }else{
                    
                    error_log('LoginModel::login->PASSWORD NO ES IGUAL');
                    return NULL;
                }
            }
        } catch (PDOException $e) {
            error_log('LoginModel::login->exception' . $e);
            return NULL;
        }
    }
}


?>