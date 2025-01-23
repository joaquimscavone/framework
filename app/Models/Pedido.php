<?php

namespace App\Models;

use Fmk\Database\Query;
use Fmk\MVC\Model;

class Pedido extends Model{
    

    public function produto():Query{
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}