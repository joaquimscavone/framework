<?php

namespace Fmk\Rules;

use Fmk\Interfaces\Rule;

class Min implements Rule{
    protected $min;
    public function __construct(float $min){
        $this->min = $min;
    }

    public function passes(&$value):bool{
        return floatval($value) >= $this->min;
    }

    public function error($attribute):string{
        return "$attribute deve ser menor ou igual a $this->min.";
    }
}