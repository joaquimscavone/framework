<?php

namespace App\Models;

use Fmk\Database\Query;
use Fmk\MVC\Model;

class Atendimento extends Model{
    public function pedidos():Query{
        return $this->hasMany(Pedido::class,'atendimento_id');
    }

    public function getTotal(){
        $total = 0; 
        foreach($this->pedidos as $pedido){
            $total+= $pedido->valor_un * $pedido->quantidade;
        }
        return $total;
    }

    public static function getMesas(){
        $nmesas = defined('N_MESAS')?constant('N_MESAS'):1;
        $mesas = [];
        for($x=1; $x<=$nmesas; $x++){
            $mesas[$x] = null;
        }
        $atendimentos = self::where('pagamento_data','is',null)->get();
        foreach ($atendimentos as $atendimento) {
            $mesas[$atendimento->mesa] = $atendimento;
        }
        return $mesas;
    }
}