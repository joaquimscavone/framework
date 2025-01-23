<?php

namespace App\Controllers;

use App\Components\NotifyComponent;
use App\Models\Funcionario;
use Fmk\MVC\Controller;
use Fmk\Utils\Request;
use Fmk\Utils\Router;
use Fmk\Utils\Session;

class LoginController extends Controller{


    public function index(){
        return view('auth.login',[''],'blank');
    }

    public function logar(){
        $request = Request::getInstance();
        //loigin e senha...
       
        $login = $request->validate('login', 'Usuário')->required();
        $senha = $request->validate('senha','Senha')->required();
        if(!$request->validation()){
            NotifyComponent::error('Existem erros de preenchimento no formulário');
            Router::getRouteByName('login')->redirect();
        }
        Funcionario::Auth($login, $senha);
        if(Funcionario::Auth($login, $senha)){
            return Router::getRouteByName('home')->redirect();
        }
        NotifyComponent::warning('Credenciais inválidas!');
        return Router::getRouteByName('login')->redirect();
    }
    public function logout(){
        $request = Request::getInstance();
        Session::getInstance()->userUnregister();
        return Router::getRouteByName('login')->redirect();
    }
}