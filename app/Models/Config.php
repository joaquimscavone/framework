<?php

namespace App\Models;

use Fmk\MVC\Model;

class Config extends Model{
    public static function all(){
        $all = parent::all();
        $result = [];
        foreach($all as $const){
            $result[$const->name] = $const->value;
        }
        return $result;
    }
}