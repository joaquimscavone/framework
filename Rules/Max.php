<?php

namespace Fmk\Rules;

use Fmk\Interfaces\Rule;

class Max implements Rule{
    protected $max;
    public function __construct(float $max){
        $this->max = $max;
    }

    public function passes(&$value):bool{
        return floatval($value) <= $this->max;
    }

    public function error($attribute):string{
        return "$attribute deve ser menor ou igual a $this->max.";
    }
}