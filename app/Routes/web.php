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
Router::get('funcionario/{id}',[App\Controllers\FuncionariosController::class,'edit'])->name('funcionario.edit');
Router::post('funcionario',[App\Controllers\FuncionariosController::class,'storage'])->name('funcionario.storage');
Router::post('funcionario/delete',[App\Controllers\FuncionariosController::class,'storage'])->name('funcionario.delete');




Router::get('gorjetas/{funcionario_id}/{data}',function($funcionario_id,$data){
    echo "Gorjetas do Funcionario $funcionario_id no dia $data";
})->name("funcionario.gorjeta");