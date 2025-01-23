<?php

namespace App\Models;

use Fmk\MVC\Model;

class Produto extends Model{
    

    public function pedidos(){
        return $this->hasMany(Pedido::class,"produto_id");
    }
}