<?php

namespace App\Controllers;

use App\Components\NotifyComponent;
use App\Models\Funcionario;
use Fmk\MVC\Controller;
use Fmk\Utils\Request;
use Fmk\Utils\Session;

class FuncionariosController extends Controller{
    /**
     * Listar Funcionários do Sistema
     * @return void
     */

    public function __construct(){
        $this->middlewares('auth');
    }

    public function index(){
        return view('funcionarios.list',['funcionarios'=> Funcionario::all()],'main');
    }

    /**
     * Exbir o formulário de adição de funcionário
     * @return void
     */
    public function create(){
        return view('funcionarios.cadastro',[],'main');
    }

    /**
     * Salva o funcionário no banco de dados
     * @param mixed $id
     * @return void
     */
    public function storage(){
        $request = Request::getInstance();
        $request->validate('id')->isInt()->required()->dbExists(Funcionario::class);
        if(!$request->validation()){
            NotifyComponent::error("Existem erros de preenchimento no formulário.");
            return $request->old()->redirect();
        }

        if($request->id == user()->id){
            NotifyComponent::error("Você não pode excluir a conta do usuário logado!");
            return $request->old()->redirect();
        }
        
        Funcionario::find($request->id)->delete();
        NotifyComponent::success("Funcionário Excluído com sucesso!");
        return $request->old()->redirect();

    }

    /**
     * Abre a tela de edição de um determinado funcionário
     * @param mixed $id
     * @return void
     */
    public function edit($id){

    }

    /**
     * Apaga um funcionário da base de dados
     * @return void
     */
    public function delete(){

    }
}