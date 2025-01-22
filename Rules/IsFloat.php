<?php

namespace Fmk\Rules;

use Fmk\Interfaces\Rule;

class IsFloat implements Rule{
   
    public function passes(&$value):bool{
        if(floatval($value) == $value){
            $value = floatval($value);
            return true;
        }
        return false;
    }

    public function error($attribute):string{
        return "$attribute precisa ser um número real.";
    }
}