<?php

namespace Fmk\Rules;

use Fmk\Interfaces\Rule;

class isInt implements Rule{
   
    public function passes(&$value):bool{
        if(intval($value) == $value){
            $value = intval($value);
            return true;
        }
        return false;
    }

    public function error($attribute):string{
        return "$attribute precisa ser um número inteiro.";
    }
}