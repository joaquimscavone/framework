<?php

namespace Fmk\Utils;

use Fmk\Interfaces\Rule;

class Validate{
    protected $errors = [];

    protected $value;

    protected $name;

    public function __construct($name, $value){
        $this->name = $name;
        $this->value = $value;
    }

    public function __call($method, $args){
        try{
            $rules = Config::getConfig('rules');
            if(array_key_exists($method,$rules)){
                $class = new \ReflectionClass($rules[$method]);
                return $this->validate($class->newInstanceArgs($args));
            }
        }catch(\Exception $e){}

        $class = constant('RULES_FMK').ucwords($method);
        if(class_exists($class) && is_subclass_of($class, Rule::class)){
            $class = new \ReflectionClass($class);
            return $this->validate($class->newInstanceArgs($args));
        }
        throw new \Exception("Erro de Validação: a Validação $method não foi encontrada!");

    }

    protected function validate(Rule $rule){
        if(!$rule->passes($this->value)){
            return $this->addError($rule->error($this->name));
        }
        return $this;
    }

    public function addError($msg){
        $this->errors[] = $msg;
        return $this;
    }

    public function check(){
        return empty($this->errors);
    }

    public function getErrors(){
        return $this->errors;
    }

    public function getValue(){
        return $this->value;
    }

    public function __tostring(){
        return $this->value;
    }
}