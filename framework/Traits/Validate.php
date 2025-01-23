<?php

namespace Fmk\Traits;

trait Validate{

    protected $validates = [];

    public function validate($name, string $label = null){
        $label = (is_null($label))?$name:$label;
        return $this->validates[$name] = new \Fmk\Utils\Validate($label,$this->$name);
     }

     public function validation(){
        $validation = true;
        foreach($this->validates as $validate){
            if(!$validate->check()){
                $validation = false;
            }
        }
        return $validation;
     }

     public function getValidate($name){
        return $this->validates[$name] ?? null;
     }
}