<?php

namespace App\Controllers;

use App\Components\NotifyComponent;
use App\Models\Funcionario;
use App\Models\Produto;
use Fmk\MVC\Controller;
use Fmk\Utils\Request;

class ProdutosController extends Controller
{

    public function __construct()
    {
        $this->middlewares('auth');
    }
    /**
     * Listar Funcionários do Sistema
     * @return string
     */
    public function index()
    {
        return view('produtos.list', ['produtos' => Produto::all()], 'main');
    }

    /**
     * Exbir o formulário de adição de funcionário
     * @return string
     */
    public function create()
    {
        return view('produtos.cadastro', [], 'main');
    }

    /**
     * Salva o funcionário no banco de dados
     * @param mixed $id
     * @return void
     */
    public function storage()
    {
        $request = Request::getInstance();
        $nome = $request->validate('nome', 'Nome')->required();
        $descricao = $request->validate('descricao', 'Descrição')->required();
        $valor_un = $request->validate('valor_un', 'Valor Unitário')->isFloat()->required();
        $unidade_medida = $request->validate('unidade_medida','Unidade de Medida')->required();
        $disponivel = ($request->disponivel)?1:0;
        if (!$request->validation()) {
            NotifyComponent::error("Existem erros de preenchimento no formulário.");
            return $request->old()->redirect();
        }
       
        $data = compact('nome', 'descricao','valor_un','unidade_medida','disponivel');
        Produto::create($data);
        NotifyComponent::success("Produto $nome cadastrado com sucesso!");
        return route('produto.list')->redirect();

    }


    public function update($id)
    {
        $request = Request::getInstance();
        $id = $request->validate('id')->required()->isInt()->dbExists(Produto::class)->confirme($id);
        $nome = $request->validate('nome', 'Nome')->required();
        $descricao = $request->validate('descricao', 'Descrição')->required();
        $valor_un = $request->validate('valor_un', 'Valor Unitário')->isFloat()->required();
        $unidade_medida = $request->validate('unidade_medida','Unidade de Medida')->required();
        $disponivel = ($request->disponivel)?1:0;
        
        if (!$request->validation()) {
            NotifyComponent::error("Existem erros de preenchimento no formulário.");
            return $request->old()->redirect();
        }
        
        $data = compact('nome', 'descricao','valor_un','unidade_medida','disponivel');
        $produto = Produto::find($id);
        $produto->save($data);
        NotifyComponent::success("Produto $nome alterado com sucesso!");
        return route('produto.list')->redirect();

    }


    /**
     * Abre a tela de edição de um determinado funcionário
     * @param mixed $id
     * @return string
     */
    public function edit($id)
    {
        $produto = Produto::find($id);
        if ($produto === false) {
            NotifyComponent::error("Produto não encontrado.");
            return route('produto.list')->redirect();
        }
        return view('produtos.edit', $produto->toArray(), 'main');
    }

    /**
     * Apaga um funcionário da base de dados
     * @return void
     */
    public function delete()
    {
        $request = Request::getInstance();
        $request->validate('id')->required()->isInt()->dbExists(Funcionario::class);
        if (!$request->validation()) {
            NotifyComponent::error("Existem erros de preenchimento no formulário.");
            return $request->old()->redirect();
        }

        Produto::find($request->id)->delete();
        NotifyComponent::success("Produto Excluído com sucesso!");
        return $request->old()->redirect();
    }
}