<?php

namespace Fmk\Rules;

use Fmk\Interfaces\Rule;

class Confirme implements Rule{
    protected $confirme;
    public function __construct($confirme){
        $this->confirme = $confirme;
    }

    public function passes(&$value):bool{
        return $value == $this->confirme;
    }

    public function error($attribute):string{
        return "$attribute não é igual a confirmação.";
    }
}