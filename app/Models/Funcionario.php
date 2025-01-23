<?php

namespace App\Models;

use Fmk\Interfaces\Auth;
use Fmk\MVC\Model;

class Funcionario extends Model implements Auth{

    public function login(){
        session()->userRegister(Funcionario::find($this->id));
    }

    public static function Auth($login,$password){
        $login = self::select('id','login','password')->where('login','=',$login)->first();
        if($login){
            if(password_verify($password, $login->password)){
                $login->login();
                return true;
            }
        }
        return false;
    }

    public function logout(){
        session()->userUnregister();
    }
}