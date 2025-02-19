<?php

use Fmk\Utils\Router;

Router::get('/',[App\Controllers\HomeController::class, 'index'])->name('home')->middlewares('auth');
Router::get('/login',[App\Controllers\LoginController::class, 'index'])->name('login')->middlewares('noAuth');
Router::post('/logar',[App\Controllers\LoginController::class, 'logar'])->name('logar');
Router::get('/logout',[App\Controllers\LoginController::class, 'logout'])->middlewares('auth');

Router::get('/mesa/{id}',function($id){
    echo "Abriu a mesa $id";
});

Router::post('mesa/{id}/pedido',function($id){
    echo "Adicionou o Pedido";
});
Router::get('mesa/{id}/pedidos',function($id){
    echo "Pegar Pedidos da mesa $id";
})->name('mesa.pedidos');

//Rotas de funcionário
Router::get('funcionarios',[App\Controllers\FuncionariosController::class,'index'])->name('funcionario.list');
Router::get('funcionario/novo',[App\Controllers\FuncionariosController::class,'create'])->name('funcionario.create');
Router::post('funcionario/delete',[App\Controllers\FuncionariosController::class,'delete'])->name('funcionario.delete');
Router::get('funcionario/{id}',[App\Controllers\FuncionariosController::class,'edit'])->name('funcionario.edit');
Router::post('funcionario/{id}',[App\Controllers\FuncionariosController::class,'update']);
Router::post('funcionario',[App\Controllers\FuncionariosController::class,'storage'])->name('funcionario.storage');

Router::get('produtos',[App\Controllers\ProdutosController::class,'index'])->name('produto.list');
Router::get('produto/novo',[App\Controllers\ProdutosController::class,'create'])->name('produto.create');
Router::post('produto/delete',[App\Controllers\ProdutosController::class,'delete'])->name('produto.delete');
Router::get('produto/{id}',[App\Controllers\ProdutosController::class,'edit'])->name('produto.edit');
Router::post('produto/{id}',[App\Controllers\ProdutosController::class,'update']);
Router::post('produto',[App\Controllers\ProdutosController::class,'storage'])->name('produto.storage');


Router::get('gorjetas/{funcionario_id}/{data}',function($funcionario_id,$data){
    echo "Gorjetas do Funcionario $funcionario_id no dia $data";
})->name("funcionario.gorjeta");