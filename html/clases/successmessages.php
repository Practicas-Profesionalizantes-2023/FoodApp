<?php

class SuccessMessages{

    const SUCCESS_ADMIN_NEWCATEGORY_EXISTS = "39e1d94aaae41a3ab7c6f71dd2d6f5e3";

    private $successList = [];

    public function __construct() {
        $this->successList = [
            SuccessMessages::SUCCESS_ADMIN_NEWCATEGORY_EXISTS=>'exito'
        ];
        
    }
    public function get($hash){
        return $this->successList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key, $this->successList)){
            return true;
        }else{
            return false;
        }
    }
}



?>