<?php

class LoginModel extends Model{

    function __constructor(){
        parent::__construct();
    }

    function login($username, $password){//nuevo
        try {
            $query = $this->prepare('SELECT * FROM users WHERE username = :username');
            $query->execute(['username' => $username]);
            
            if($query->rowCount() == 1){
                $item = $query->fetch(PDO::GETCH_ASSOC)
                
                $user = new UserModel();
                $user->from($item);

                if(password_verify($password, $user->getPassword())){
                    error_log('LoginModel::login->success');
                    return $user;
                }else{
                    return NULL;
                    error_log('LoginModel::login->PASSWORD NO ES IGUAL');
                }
            }
        } catch (PDOException $e) {
            error_log('LoginModel::login->exception' . $e);
            return NULL;
        }
    }
}


?>