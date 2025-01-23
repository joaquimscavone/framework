<?php

namespace Fmk\MVC;

use Fmk\Database\DB;
use Fmk\Database\Query;

abstract class Model{
    static protected $table;
    static protected $conneciton_name;

    static protected $pk = 'id';

    static protected $columns = ['*'];

    protected $data = [];
    protected $old = [];

    protected $exists;

    protected $relationships = [];

    public function __construct(){
        $this->exists = !empty($this->data);
        $this->old = $this->data;
    }

    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function __get($name){
        return $this->data[$name] ?? $this->checkRelationship($name);
    }

    public function __isset($name){
        return isset($this->data[$name]);
    }

    public static function query(){
        return DB::connection(static::$conneciton_name)->table(static::class);
    }

    public static function getTableName(){
        if(static::$table){
            return static::$table;
        }
        return strtolower(basename(static::class))."s";
    }

    public static function find($id){
        return static::query()->select(static::$columns)
        ->where(static::$pk,'=',$id)->first();
    }
    public static function all(){
        return static::query()->select(static::$columns)->get();
    }

    public static function create(array $data){
        $id = static::query()->insert($data);
        return static::find($id);
    }


    public static function select($columns){
        return static::query()->select((is_array($columns)) ? $columns : func_get_args());
        
    }

    public static function where($column, $operator = null, $value = null){
        return static::query()->where($column,$operator,$value);
    }
    public static function orWhere($column, $operator = null, $value = null){
        return static::query()->where($column,$operator,$value);
    }

    public static function limit(int $limit, int $offset = null){
        return static::query()->limit($limit,$offset);
    }

    public static function orderDesc($column){
       return static::query()->orderDesc($column);
    }
    
    public static function orderAsc($column){
        return static::query()->orderDesc($column);
    }

    
    public function isStorage(){
        return $this->exists;
    }
    
    public function save(array $data = []){
        $this->data = array_merge($this->data,$data);
        if($this->isStorage()){
            return $this->update();
        }
        return $this->insert();
    }

    protected function insert(){
        $pk = static::$pk;
        $data = $this->data;
        unset($data[$pk]);
        $id = static::query()->insert($this->data);
        $this->$pk = $id;
        return $this->exists = true;
    }
    protected function update(){
        $pk = static::$pk;
        $data = $this->data;
        unset($data[$pk]);
        static::query()->where($pk,'=',$this->$pk)->update($this->data);
        return true;
    }

    public function delete(){
        $pk = static::$pk;
        static::query()->where($pk,'=',$this->$pk)->delete();
        $this->exists = false;
        return true;
    }

    /**
     * Cria um relacionamento de 1 - 1 onde a chave estrangeira está na outra classe
     * @param class-string $related_class
     * @param string $foreign_key
     * @return Query
     */
    protected function hasOne($related_class, $foreign_key){
        return $related_class::query()->where($foreign_key, '=', $this->id)->setCallback('first');
    }
    /**
     * Cria um relacionamento de 1 - 1 onde a chave estrangeira está na minha classe
     * @param class-string $related_class
     * @param string $local_key
     * @return Query
     */
    protected function belongsTo($related_class, $local_key){
        return $related_class::query()->where($related_class::$pk, '=', $this->$local_key)->setCallback('first');
    }
    /**
     * Cria um relacionamento de 1-n com outra tabela onde os registros estejam em outras tabelas.
     * @param class-string $related_class
     * @param string $foreign_key
     * @return Query
     */
    protected function hasMany($related_class,$foreign_key){
        return $related_class::query()->where($foreign_key, '=', $this->id)->setCallback('get');
    }

    public function checkRelationship($name){
       if(isset($this->relationships[$name])){
            return $this->relationships[$name];
       }
       
        if(method_exists($this, $name)){
            $reflaction = new \ReflectionMethod(static::class, $name);
            if($reflaction->getReturnType()->getName() == Query::class){
                $this->relationships[$name] = $this->$name()->exec();
                return $this->relationships[$name];
            }
        }

        return null;
    }

    public function reload(){   
        $this->relationships = [];
        $this->old = $this->data;
        $data =  DB::connection(static::$conneciton_name)
            ->table(static::getTableName())
            ->where(static::$pk,'=',$this->{static::$pk})
            ->first();
        $this->data = ($data === false)?[]:$data;
        $this->exists = !empty($this->data);
        return true;
    }

    public static function getPk(){
        return self::$pk;
    }
    



}