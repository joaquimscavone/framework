<?php

namespace Fmk\Rules;

use Fmk\Interfaces\Rule;
use Fmk\MVC\Model;

class DbExists implements Rule{

    protected $model;

    protected $col;
    
    /**
     * Summary of __construct
     * @param Model|class-string $model
     * @param string $col
     */
    public function __construct($model, $col = null){
        if(!is_subclass_of($model, Model::class)){
            throw new \Exception("O Objeto|Classe informado não é da classe model");
        }
        if(is_object($model)){
            $model = get_class($model);
        }

        if(is_null($col)){
            $col = $model::getPk();
        }

        $this->model = $model;
        $this->col = $col;

    }

    public function passes(&$value): bool{
        $data = $this->model::select($this->col)->where($this->col, '=', $value)->first();
        return ($data !== false);
    }

    public function error($attribute):string{
        return "$attribute não existe no banco de dados!";
    }
}